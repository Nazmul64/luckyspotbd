<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supporemail;
use Illuminate\Http\Request;

class AdminsupportemailController extends Controller
{
  public function contact_messages()
{
    $supportemails = Supporemail::orderBy('id', 'desc')->get();
    return view('admin.messages.index', compact('supportemails'));
}

public function contactmessagesdelete($id)
{
    $message = Supporemail::findOrFail($id);
    $message->delete();

    return redirect()
        ->back()
        ->with('success', 'Message deleted successfully!');
}


}
