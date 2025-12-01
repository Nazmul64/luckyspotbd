<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmindepositeblanceaddController extends Controller
{
    /**
     * Show all Users for Deposit Check
     */
    public function adminuserdepositecheck()
    {
        $users = User::where('role', 'user')->orderBy('id', 'DESC')->get();
        return view('admin.depositeaddforadmin.depositeaddforadmin', compact('users'));
    }

    /**
     * Edit specific User balance
     */
    public function depositebalanceEdit($id)
    {
        $users = User::where('role', 'user')->get();

        $balance_edit = Deposite::firstOrNew(
            ['user_id' => $id],
            [
                'amount' => 0,
                'status' => 'pending',     // ডিফল্ট
                'approved_by' => null,
            ]
        );

        return view('admin.depositeaddforadmin.depositeaddforadminedit',
            compact('balance_edit', 'users')
        );
    }

    /**
     * Update or Create User balance
     */
    public function depositebalanceUpdate(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:0',
        ]);

        Deposite::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'amount'       => $request->amount,
                'status'       => 'approved',           // balance change মানেই admin approved
                'approved_by'  => Auth::id(),           // কে approve করল
                'payment_method' => 'manual',           // error fix
            ]
        );

        return back()->with('success', '💰 Balance updated & Approved Successfully!');
    }

    /**
     * Delete a user
     */
    public function usrdelete($id)
    {
        $user_delete = User::findOrFail($id);
        $user_delete->delete();

        return back()->with('success','User deleted successfully!');
    }
}
