<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {

        $user_count=User::where('role','user')->count();
        return view('admin.index',compact('user_count'));
    }
       // user list for admin
    public function userlistadmin(){
        $users=User::where('role','user')->get();
        return view('admin.userlist.index',compact('users'));
    }
        public function updateStatus(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->status = $request->status;
    $user->save();

    return redirect()->back()->with('success', 'User status updated successfully!');
}
public function  userDelete(Request $request,$id){
   $user_delete=User::find($id);
   $user_delete->delete();
    return redirect()->back()->with('success', 'User Delete successfully!');
}
}
