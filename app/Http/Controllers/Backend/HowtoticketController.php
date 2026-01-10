<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Howtoticket;
use Illuminate\Http\Request;

class HowtoticketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $howtotickets = Howtoticket::latest()->get();
        return view('admin.howtoticket.index', compact('howtotickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = config('app.languages', ['en' => 'English', 'bn' => 'Bangla']);
        return view('admin.howtoticket.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title.*' => 'required|string|max:255',
            'description.*' => 'nullable|string',
            'sign_up_first_login.*' => 'nullable|string',
            'complete_your_profile.*' => 'nullable|string',
            'choose_a_ticket.*' => 'nullable|string',
            'sign_up_first_login_icon' => 'nullable|string',
            'complete_your_profile_icon' => 'nullable|string',
            'choose_a_ticket_icon' => 'nullable|string',
        ]);

        Howtoticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'sign_up_first_login' => $request->sign_up_first_login,
            'complete_your_profile' => $request->complete_your_profile,
            'choose_a_ticket' => $request->choose_a_ticket,
            'sign_up_first_login_icon' => $request->sign_up_first_login_icon,
            'complete_your_profile_icon' => $request->complete_your_profile_icon,
            'choose_a_ticket_icon' => $request->choose_a_ticket_icon,
        ]);

        return redirect()
            ->route('howtoticket.index')
            ->with('success', 'How To Ticket created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $howtoticket = Howtoticket::findOrFail($id);
        $languages = config('app.languages', ['en' => 'English', 'bn' => 'Bangla']);
        return view('admin.howtoticket.edit', compact('howtoticket', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title.*' => 'required|string|max:255',
            'description.*' => 'nullable|string',
            'sign_up_first_login.*' => 'nullable|string',
            'complete_your_profile.*' => 'nullable|string',
            'choose_a_ticket.*' => 'nullable|string',
            'sign_up_first_login_icon' => 'nullable|string',
            'complete_your_profile_icon' => 'nullable|string',
            'choose_a_ticket_icon' => 'nullable|string',
        ]);

        $howtoticket = Howtoticket::findOrFail($id);
        $howtoticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'sign_up_first_login' => $request->sign_up_first_login,
            'complete_your_profile' => $request->complete_your_profile,
            'choose_a_ticket' => $request->choose_a_ticket,
            'sign_up_first_login_icon' => $request->sign_up_first_login_icon,
            'complete_your_profile_icon' => $request->complete_your_profile_icon,
            'choose_a_ticket_icon' => $request->choose_a_ticket_icon,
        ]);

        return redirect()
            ->route('howtoticket.index')
            ->with('success', 'How To Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $howtoticket = Howtoticket::findOrFail($id);
        $howtoticket->delete();

        return redirect()
            ->route('howtoticket.index')
            ->with('success', 'How To Ticket deleted successfully');
    }
}
