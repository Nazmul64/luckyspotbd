<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use App\Models\Deposite;
use App\Models\Lottery;
use App\Models\Profit;
use App\Models\Userpackagebuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserlottryController extends Controller
{
    /**
     * Buy a lottery/package
     */
    public function buyPackage(Request $request, int $packageId)
    {
        $user = Auth::user();
        $package = Lottery::findOrFail($packageId);

        DB::beginTransaction();

        try {
            // 🔒 Lock deposit
            $deposit = Deposite::where('user_id', $user->id)
                ->where('status', 'approved')
                ->lockForUpdate()
                ->first();

            if (!$deposit || $deposit->amount < $package->price) {
                DB::rollBack();
                return back()->with('error', 'Insufficient balance.');
            }

            // 💰 Deduct balance
            $deposit->decrement('amount', $package->price);

            // 🎟 Ticket number
            $ticketNumber = $this->generateTicket($package);

            // 📦 Save purchase
            Userpackagebuy::create([
                'user_id'       => $user->id,
                'package_id'    => $package->id,
                'ticket_number' => $ticketNumber,
                'price'         => $package->price,
                'status'        => 'active',
            ]);

            // 📉 Expense log
            Profit::create([
                'user_id'      => $user->id,
                'from_user_id' => $user->id,
                'deposit_id'   => $deposit->id,
                'amount'       => -$package->price,
                'level'        => 0,
                'note'         => 'Package purchase',
            ]);

            // ⚙️ Commission
            $settings = CommissionSetting::first();
            if ($settings && $settings->status) {

                // ✅ Referral bonus ONLY ONCE
                $this->distributeReferralCommissionOnce(
                    $user,
                    $package,
                    $settings,
                    $deposit->id
                );

                // 🔁 Generation commission (non-lottery)
                if ($package->type !== 'lottery') {
                    $this->distributeGenerationCommission(
                        $user,
                        $package,
                        $settings,
                        $deposit->id
                    );
                }
            }

            DB::commit();

            return back()->with([
                'success' => 'Package purchased successfully!',
                'ticket_number' => $ticketNumber
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Generate ticket number
     */
    protected function generateTicket($package)
    {
        if ($package->type !== 'lottery') {
            return 'N/A-' . uniqid();
        }

        do {
            $ticket = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (Userpackagebuy::where('ticket_number', $ticket)->exists());

        return $ticket;
    }

    /**
     * Referral commission (ONLY ONCE PER USER)
     */
    protected function distributeReferralCommissionOnce($user, $package, $settings, int $depositId)
    {
        $referrer = $user->referrer;
        if (!$referrer || $settings->refer_commission <= 0) {
            return;
        }

        // ❌ Already paid check
        $alreadyPaid = Profit::where('from_user_id', $user->id)
            ->where('level', 1)
            ->where('note', 'Referral commission')
            ->exists();

        if ($alreadyPaid) {
            return;
        }

        $bonus = round($package->price * ($settings->refer_commission / 100), 2);
        if ($bonus <= 0) return;

        $referrer->increment('balance', $bonus);
        $referrer->increment('refer_income', $bonus);

        Profit::create([
            'user_id'      => $referrer->id,
            'from_user_id' => $user->id,
            'deposit_id'   => $depositId,
            'amount'       => $bonus,
            'level'        => 1,
            'note'         => 'Referral commission',
        ]);
    }

    /**
     * Generation commission (up to 5 levels)
     */
    protected function distributeGenerationCommission($user, $package, $settings, int $depositId)
    {
        $currentUser = $user;
        $baseAmount = round($package->price * ($settings->generation_commission / 100), 2);

        $levels = [
            1 => $settings->generation_level_1,
            2 => $settings->generation_level_2,
            3 => $settings->generation_level_3,
            4 => $settings->generation_level_4,
            5 => $settings->generation_level_5,
        ];

        for ($level = 1; $level <= 5; $level++) {
            $referrer = $currentUser->referrer;
            if (!$referrer || ($levels[$level] ?? 0) <= 0) break;

            $bonus = round($baseAmount * ($levels[$level] / 100), 2);

            if ($bonus > 0) {
                $referrer->increment('balance', $bonus);
                $referrer->increment('generation_income', $bonus);

                Profit::create([
                    'user_id'      => $referrer->id,
                    'from_user_id' => $user->id,
                    'deposit_id'   => $depositId,
                    'amount'       => $bonus,
                    'level'        => $level,
                    'note'         => "Generation commission (Level {$level})",
                ]);
            }

            $currentUser = $referrer;
        }
    }
}
