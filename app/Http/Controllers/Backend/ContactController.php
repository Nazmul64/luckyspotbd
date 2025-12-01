<?php

namespace App\Http\Controllers\Backend;

use App\Models\cr;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.contact.index', [
            'contact' =>Contact::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // 1️⃣ Validate input
    $request->validate([
        'icon'        => 'nullable|string|max:255',
        'title'       => 'required|string|max:255',
        'email_phone' => 'required|string|max:255',
        'status'      => 'required|boolean',
    ]);

    // 2️⃣ Create new contact
    \App\Models\Contact::create([
        'icon'        => $request->icon,
        'title'       => $request->title,
        'email_phone' => $request->email_phone,
        'map_code'    => $request->map_code,
        'status'      => $request->status,
    ]);

    // 3️⃣ Redirect back with success message
    return redirect()->route('contact.index')->with('success', 'Contact created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    // 1️⃣ Find the contact
    $contact = \App\Models\Contact::find($id);

    if (!$contact) {
        return redirect()->route('contact.index')->with('error', 'Contact not found.');
    }

    // 2️⃣ Validate input
    $request->validate([
        'icon'        => 'nullable|string|max:255',
        'title'       => 'required|string|max:255',
        'email_phone' => 'required|string|max:255',
        'status'      => 'required|boolean',
    ]);

    // 3️⃣ Update the contact
    $contact->update([
        'icon'        => $request->icon,
        'title'       => $request->title,
        'email_phone' => $request->email_phone,
        'map_code'    => $request->map_code,
        'status'      => $request->status,
    ]);

    // 4️⃣ Redirect back with success message
    return redirect()->route('contact.index')->with('success', 'Contact updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
        } else {
            return redirect()->route('contact.index')->with('error', 'Contact not found.');
        }
    }
}
