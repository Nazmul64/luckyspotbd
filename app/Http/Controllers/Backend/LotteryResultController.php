<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lottery;
use App\Models\Userpackagebuy;
use App\Models\LotteryResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     */
    public function declareResult(Request $request, $lotteryId)
    {
        $request->validate([
            'random'         => 'nullable|boolean',
            'first_winner'   => 'nullable|exists:users,id',
            'second_winner'  => 'nullable|exists:users,id',
            'third_winner'   => 'nullable|exists:users,id',
            'first_prize'    => 'nullable|numeric|min:0',
            'second_prize'   => 'nullable|numeric|min:0',
            'third_prize'    => 'nullable|numeric|min:0',
            'multiple_title' => 'nullable|array',
            'multiple_price' => 'nullable|array',
        ]);

        // Get all tickets for this lottery without results
        $tickets = Userpackagebuy::with('user')
            ->where('package_id', $lotteryId)
            ->whereDoesntHave('results')
            ->get();

        if ($tickets->isEmpty()) {
            return back()->with('error', 'No eligible tickets found.');
        }

        $multipleTitles = $request->multiple_title ?? [];
        $multiplePrices = $request->multiple_price ?? [];

        // =========================
        // SELECT WINNERS
        // =========================
        $winnerTickets = collect();

        if ($request->boolean('random')) {
            // Randomly pick 3 tickets as winners
            $winnerTickets = $tickets->shuffle()->take(3);
        } else {
            // Manually selected winners
            foreach (['first_winner', 'second_winner', 'third_winner'] as $key) {
                if ($request->$key) {
                    $ticket = $tickets->firstWhere('user_id', $request->$key);
                    if ($ticket) {
                        $winnerTickets->push($ticket);
                    }
                }
            }
        }

        // Collect all unique winning user IDs
        $winningUserIds = $winnerTickets->pluck('user_id')->unique();

        // =========================
        // DB TRANSACTION
        // =========================
        DB::transaction(function () use ($tickets, $winnerTickets, $winningUserIds, $request, $multipleTitles, $multiplePrices) {

            $prizes = [
                'first'  => $request->first_prize ?? 0,
                'second' => $request->second_prize ?? 0,
                'third'  => $request->third_prize ?? 0,
            ];

            // =========================
            // HANDLE WINNERS
            // =========================
            foreach ($winnerTickets as $index => $ticket) {
                $user = User::lockForUpdate()->find($ticket->user_id);
                if (!$user) continue;

                $position = ['first', 'second', 'third'][$index] ?? null;

                // Total gift = admin declared prize + sum of multiple_price
                $giftAmount = ($prizes[$position] ?? 0) + array_sum($multiplePrices);

                // Only add balance for winners
                if ($giftAmount > 0) {
                    $user->increment('balance', $giftAmount);
                }

                // Create lottery result record
                LotteryResult::create([
                    'user_package_buy_id' => $ticket->id,
                    'user_id'             => $ticket->user_id,
                    'win_status'          => 'won',
                    'win_amount'          => $ticket->price,
                    'gift_amount'         => $giftAmount,
                    'position'            => $position,
                    'draw_date'           => now(),
                    'status'              => 'active',
                    'multiple_title'      => $multipleTitles,
                    'multiple_price'      => $multiplePrices,
                ]);
            }

            // =========================
            // HANDLE LOSERS
            // =========================
            $losers = $tickets->filter(fn($ticket) => !$winningUserIds->contains($ticket->user_id));

            foreach ($losers as $ticket) {
                LotteryResult::create([
                    'user_package_buy_id' => $ticket->id,
                    'user_id'             => $ticket->user_id,
                    'win_status'          => 'lost',
                    'win_amount'          => $ticket->price,
                    'gift_amount'         => 0, // no balance added
                    'position'            => null,
                    'draw_date'           => now(),
                    'status'              => 'active',
                    'multiple_title'      => $multipleTitles,
                    'multiple_price'      => $multiplePrices,
                ]);
            }

            // =========================
            // UPDATE LOTTERY STATUS
            // =========================
            $pending = Userpackagebuy::where('package_id', $tickets->first()->package_id)
                ->whereDoesntHave('results')
                ->count();

            $lottery = Lottery::lockForUpdate()->find($tickets->first()->package_id);
            if ($lottery) {
                $lottery->status = $pending > 0 ? 'active' : 'completed';
                $lottery->save();
            }
        });

        return back()->with('success', '🎉 Winners declared and balances updated successfully!');
    }
}
