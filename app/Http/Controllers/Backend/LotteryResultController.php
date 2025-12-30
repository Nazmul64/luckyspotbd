<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Userpackagebuy;
use App\Models\LotteryResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LotteryResultController extends Controller
{
    /**
     * SHOW LOTTERY LIST WITH TICKET INFO
     */
    public function purchasedTickets(Request $request)
    {
        $winType = $request->get('type');

        $query = Lottery::withCount([
                'userPackageBuys as tickets_sold' => fn($q) => $q->whereDoesntHave('results')
            ])
            ->withSum([
                'userPackageBuys as total_amount' => fn($q) => $q->whereDoesntHave('results')
            ], 'price')
            ->latest();

        if ($winType) {
            $query->where('win_type', $winType);
        }

        $lotteries = $query->get();

        // Update lottery status based on pending tickets
        foreach ($lotteries as $lottery) {
            $pending = Userpackagebuy::where('package_id', $lottery->id)
                ->whereDoesntHave('results')
                ->count();

            $lottery->status = $pending > 0 ? 'active' : 'completed';
        }

        return view('admin.lotterywin.show', compact('lotteries', 'winType'));
    }

    /**
     * SHOW DECLARE FORM FOR SPECIFIC LOTTERY
     */
    public function showDeclareForm($lotteryId)
    {
        $lottery = Lottery::findOrFail($lotteryId);

        $buyers = Userpackagebuy::with('user')
            ->where('package_id', $lotteryId)
            ->whereDoesntHave('results')
            ->get()
            ->unique('user_id');

        return view('admin.lotterywin.declare', compact('lottery', 'buyers'));
    }

    /**
     * DECLARE LOTTERY RESULT AND UPDATE USER BALANCE
     * Fully dynamic - no hardcoded values
     */
    public function declareResult(Request $request, $lotteryId)
    {
        $request->validate([
            'random'         => 'nullable|boolean',
            'first_winner'   => 'nullable|exists:users,id',
            'second_winner'  => 'nullable|exists:users,id',
            'third_winner'   => 'nullable|exists:users,id',
        ]);

        // Load lottery with prize data from database
        $lottery = Lottery::findOrFail($lotteryId);

        // Get all tickets for this lottery without results
        $tickets = Userpackagebuy::with('user')
            ->where('package_id', $lotteryId)
            ->whereDoesntHave('results')
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'No eligible tickets found.');
        }

        // Extract prize data from lottery table (database)
        $prizes = [
            'first'  => (float) ($lottery->first_prize ?? 0),
            'second' => (float) ($lottery->second_prize ?? 0),
            'third'  => (float) ($lottery->third_prize ?? 0),
        ];

        // Extract multiple prize data from lottery table (stored as JSON)
        $multipleTitles = [];
        $multiplePrices = [];
        $totalMultiplePrize = 0;

        if (!empty($lottery->multiple_title) && !empty($lottery->multiple_price)) {
            $multipleTitles = is_array($lottery->multiple_title)
                ? $lottery->multiple_title
                : json_decode($lottery->multiple_title, true) ?? [];

            $multiplePrices = is_array($lottery->multiple_price)
                ? $lottery->multiple_price
                : json_decode($lottery->multiple_price, true) ?? [];

            $totalMultiplePrize = array_sum(array_map('floatval', $multiplePrices));
        }

        // =========================
        // SELECT WINNERS (First, Second, Third)
        // =========================
        $winnerTickets = collect();

        if ($request->boolean('random')) {
            // Randomly pick 3 tickets as winners
            $winnerTickets = $tickets->shuffle()->take(3);
        } else {
            // Manually selected winners
            $manualWinners = [
                'first_winner'  => $request->first_winner,
                'second_winner' => $request->second_winner,
                'third_winner'  => $request->third_winner,
            ];

            foreach ($manualWinners as $key => $userId) {
                if ($userId) {
                    $ticket = $tickets->firstWhere('user_id', $userId);
                    if ($ticket) {
                        $winnerTickets->push($ticket);
                    }
                }
            }
        }

        // Validate we have winners
        if ($winnerTickets->isEmpty()) {
            return back()->with('error', 'No winners selected.');
        }

        // =========================
        // SELECT ONE RANDOM MULTIPLE PRIZE WINNER (optional)
        // =========================
        $multiplePrizeWinnerTicket = null;
        if ($tickets->isNotEmpty() && $totalMultiplePrize > 0) {
            $multiplePrizeWinnerTicket = $tickets->random();
        }

        // =========================
        // DB TRANSACTION
        // =========================
        DB::transaction(function () use (
            $tickets,
            $winnerTickets,
            $prizes,
            $multipleTitles,
            $multiplePrices,
            $totalMultiplePrize,
            $multiplePrizeWinnerTicket,
            $lotteryId
        ) {
            // Track processed ticket IDs
            $processedTicketIds = [];

            // Position names array - fully dynamic
            $positionNames = ['first', 'second', 'third'];

            // =========================
            // STEP 1: PROCESS MAIN WINNERS (1st, 2nd, 3rd)
            // =========================
            foreach ($winnerTickets as $index => $ticket) {
                $position = $positionNames[$index] ?? null;
                if (!$position) continue;

                // Get prize amount from database
                $prizeAmount = (float) ($prizes[$position] ?? 0);

                // Check if this ticket also won multiple prize
                $isMultiplePrizeWinner = $multiplePrizeWinnerTicket
                    && $ticket->id == $multiplePrizeWinnerTicket->id;

                // Calculate total gift
                $totalGift = $prizeAmount;
                if ($isMultiplePrizeWinner) {
                    $totalGift += $totalMultiplePrize;
                }

                // Update user balance
                if ($totalGift > 0) {
                    $user = User::lockForUpdate()->find($ticket->user_id);
                    if ($user) {
                        $oldBalance = $user->balance;
                        $user->balance = $oldBalance + $totalGift;
                        $user->save();

                        Log::info("Winner balance updated", [
                            'user_id' => $user->id,
                            'position' => $position,
                            'old_balance' => $oldBalance,
                            'new_balance' => $user->balance,
                            'gift_amount' => $totalGift
                        ]);
                    }
                }

                // Create lottery result record
                LotteryResult::create([
                    'user_package_buy_id' => $ticket->id,
                    'user_id'             => $ticket->user_id,
                    'win_status'          => 'won',
                    'win_amount'          => $ticket->price,
                    'gift_amount'         => $totalGift,
                    'position'            => $position,
                    'draw_date'           => now(),
                    'status'              => 'active',
                    'multiple_title'      => $isMultiplePrizeWinner ? json_encode($multipleTitles) : null,
                    'multiple_price'      => $isMultiplePrizeWinner ? json_encode($multiplePrices) : null,
                ]);

                $processedTicketIds[] = $ticket->id;
            }

            // =========================
            // STEP 2: PROCESS MULTIPLE PRIZE WINNER (if separate)
            // =========================
            if ($multiplePrizeWinnerTicket && !in_array($multiplePrizeWinnerTicket->id, $processedTicketIds)) {

                // Update user balance
                if ($totalMultiplePrize > 0) {
                    $user = User::lockForUpdate()->find($multiplePrizeWinnerTicket->user_id);
                    if ($user) {
                        $oldBalance = $user->balance;
                        $user->balance = $oldBalance + $totalMultiplePrize;
                        $user->save();

                        Log::info("Multiple prize winner balance updated", [
                            'user_id' => $user->id,
                            'old_balance' => $oldBalance,
                            'new_balance' => $user->balance,
                            'gift_amount' => $totalMultiplePrize
                        ]);
                    }
                }

                // Create lottery result for multiple prize winner
                LotteryResult::create([
                    'user_package_buy_id' => $multiplePrizeWinnerTicket->id,
                    'user_id'             => $multiplePrizeWinnerTicket->user_id,
                    'win_status'          => 'won',
                    'win_amount'          => $multiplePrizeWinnerTicket->price,
                    'gift_amount'         => $totalMultiplePrize,
                    'position'            => 'multiple',
                    'draw_date'           => now(),
                    'status'              => 'active',
                    'multiple_title'      => json_encode($multipleTitles),
                    'multiple_price'      => json_encode($multiplePrices),
                ]);

                $processedTicketIds[] = $multiplePrizeWinnerTicket->id;
            }

            // =========================
            // STEP 3: PROCESS REMAINING LOSERS
            // =========================
            $remainingLosers = $tickets->filter(function($ticket) use ($processedTicketIds) {
                return !in_array($ticket->id, $processedTicketIds);
            });

            foreach ($remainingLosers as $ticket) {
                LotteryResult::create([
                    'user_package_buy_id' => $ticket->id,
                    'user_id'             => $ticket->user_id,
                    'win_status'          => 'lost',
                    'win_amount'          => $ticket->price,
                    'gift_amount'         => 0,
                    'position'            => null,
                    'draw_date'           => now(),
                    'status'              => 'active',
                    'multiple_title'      => null,
                    'multiple_price'      => null,
                ]);
            }

            // =========================
            // STEP 4: UPDATE LOTTERY STATUS
            // =========================
            $pending = Userpackagebuy::where('package_id', $lotteryId)
                ->whereDoesntHave('results')
                ->count();

            $lottery = Lottery::lockForUpdate()->find($lotteryId);
            if ($lottery) {
                $lottery->status = $pending > 0 ? 'active' : 'completed';
                $lottery->save();
            }
        });

        return back()->with('success', '🎉 Winners declared and balances updated successfully!');
    }
}
