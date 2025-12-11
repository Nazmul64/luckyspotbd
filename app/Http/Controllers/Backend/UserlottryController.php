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
     * Buy a lottery/package for authenticated user
     *
     * @param Request $request
     * @param int $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buyPackage(Request $request, int $packageId)
    {
        $user = Auth::user();
        $package = Lottery::findOrFail($packageId);

        DB::beginTransaction();

        try {
            // 1️⃣ Lock approved deposit to prevent race condition
            $deposit = Deposite::where('user_id', $user->id)
                ->where('status', 'approved')
                ->lockForUpdate()
                ->first();

            if (!$deposit || $deposit->amount < $package->price) {
                DB::rollBack();
                return back()->with('error', 'Insufficient balance to buy this package.');
            }

            // 2️⃣ Deduct package price from deposit
            $deposit->decrement('amount', $package->price);

            // 3️⃣ Generate ticket number
            $ticketNumber = null;
            if ($package->type === 'lottery') {
                // 8-digit unique numeric ticket number
                do {
                    $ticketNumber = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                } while (Userpackagebuy::where('ticket_number', $ticketNumber)->exists());
            } else {
                // Non-lottery package
                $ticketNumber = 'N/A-' . uniqid();
            }

            // 4️⃣ Save user package purchase
            Userpackagebuy::create([
                'user_id'       => $user->id,
                'package_id'    => $package->id,
                'ticket_number' => $ticketNumber,
                'price'         => $package->price,
                'status'        => 'active',
            ]);

            // 5️⃣ Log expense in Profit
            Profit::create([
                'user_id'      => $user->id,
                'from_user_id' => $user->id,
                'deposit_id'   => $deposit->id,
                'amount'       => -$package->price,
                'level'        => 0,
                'note'         => 'User purchased package: ' . $package->id,
            ]);

            // 6️⃣ Handle referral & generation commissions
            $settings = CommissionSetting::first();
            if ($settings && $settings->status) {
                $this->distributeReferralCommission($user, $package, $settings, $deposit->id);

                if ($package->type !== 'lottery') {
                    $this->distributeGenerationCommission($user, $package, $settings, $deposit->id);
                }
            }

            DB::commit();

            // 7️⃣ Return success message with ticket number
            return back()->with([
                'success'       => 'Package purchased successfully!',
                'ticket_number' => $ticketNumber
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Distribute direct referral commission
     */
    protected function distributeReferralCommission($user, $package, $settings, int $depositId)
    {
        $referrer = $user->referrer;
        if (!$referrer || $settings->refer_commission <= 0) return;

        $bonus = round($package->price * ($settings->refer_commission / 100), 2);

        if ($bonus > 0) {
            $referrer->increment('balance', $bonus);
            $referrer->increment('refer_income', $bonus);

            Profit::create([
                'user_id'      => $referrer->id,
                'from_user_id' => $user->id,
                'deposit_id'   => $depositId,
                'amount'       => $bonus,
                'level'        => 1,
                'note'         => $package->type === 'lottery' ? 'Lottery referral commission' : 'Direct referral commission',
            ]);
        }
    }

    /**
     * Distribute generation commission up to 5 levels
     */
    protected function distributeGenerationCommission($user, $package, $settings, int $depositId)
    {
        $currentUser = $user;
        $stockAmount = round($package->price * ($settings->generation_commission / 100), 2);

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

            $bonus = round($stockAmount * ($levels[$level] / 100), 2);
            if ($bonus > 0) {
                $referrer->increment('balance', $bonus);
                $referrer->increment('generation_income', $bonus);

                Profit::create([
                    'user_id'      => $referrer->id,
                    'from_user_id' => $user->id,
                    'deposit_id'   => $depositId,
                    'amount'       => $bonus,
                    'level'        => $level,
                    'note'         => 'Generation commission (Level ' . $level . ')',
                ]);
            }

            $currentUser = $referrer;
        }
    }
}
