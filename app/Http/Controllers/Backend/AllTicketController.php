<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Userpackagebuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllTicketController extends Controller
{
public function ticket()
{
    $user = auth()->user();

    $tickets = Userpackagebuy::with('package', 'results')
        ->where('user_id', $user->id)
        ->orderBy('purchased_at', 'desc')
        ->get();

    return view('frontend.dashboard.allticket.allticket', compact('tickets'));
}
public function myticket(Request $request)
    {
        $user = Auth::user();
        $query = Userpackagebuy::with('package', 'results')
            ->where('user_id', $user->id)
            ->orderBy('purchased_at', 'desc');

        // Ticket number search
        if ($request->has('ticket_number') && $request->ticket_number != '') {
            $query->where('ticket_number', 'like', '%'.$request->ticket_number.'%');
        }

        $tickets = $query->get();

        return view('frontend.dashboard.allticket.allticket', compact('tickets'));
    }


}
