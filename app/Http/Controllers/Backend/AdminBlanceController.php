<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBlanceController extends Controller
{
    public function adminusercheck(){
        $users=User::where('role','user')->get();
       return view('admin.adminblanceadd.index',compact('users'));
    }

    public function adminBalanceEdit(Request $request, $id)
    {
        $blance_edit = User::findOrFail($id);
        return view('admin.adminblanceadd.edit', compact('blance_edit'));
    }

     public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = User::findOrFail($id);
        $user->balance = $request->amount; // Fixed balance set
        $user->save();

        return redirect()->back()->with('success', 'User balance updated successfully!');
    }

  public function usrdelete($id)
{
    $user_delete = User::findOrFail($id);
    $user_delete->delete();

    return redirect()->back()->with('success', 'User deleted successfully!');
}

}
