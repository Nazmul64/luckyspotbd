<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Whychooseusticket;
use Illuminate\Http\Request;

class WhychooseusticketController extends Controller
{
    public function index()
    {
        $tickets = Whychooseusticket::latest()->get();
        return view('admin.whychooseustickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('admin.whychooseustickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_title' => 'nullable|string|max:255',
            'main_description' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        Whychooseusticket::create($request->all());

        return redirect()
            ->route('whychooseustickets.index')
            ->with('success', 'Item added successfully');
    }

    public function edit(Whychooseusticket $whychooseusticket)
    {
        return view('admin.whychooseustickets.edit', [
            'ticket' => $whychooseusticket
        ]);
    }

    public function update(Request $request, Whychooseusticket $whychooseusticket)
    {
        $request->validate([
            'main_title' => 'nullable|string|max:255',
            'main_description' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $whychooseusticket->update($request->all());

        return redirect()
            ->route('whychooseustickets.index')
            ->with('success', 'Item updated successfully');
    }

    public function destroy(Whychooseusticket $whychooseusticket)
    {
        $whychooseusticket->delete();

        return redirect()
            ->route('whychooseustickets.index')
            ->with('success', 'Item deleted successfully');
    }
}
