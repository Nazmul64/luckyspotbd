<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Privacypolicy;
use Illuminate\Http\Request;

class PrivacypolicyController extends Controller
{
    public function index()
    {
        $privacypolicies = Privacypolicy::all();
        return view('admin.privacypolicy.index', compact('privacypolicies'));
    }

    public function create()
    {
        return view('admin.privacypolicy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.en' => 'required|string|max:255',
            'title.bn' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.bn' => 'required|string',
        ]);

        Privacypolicy::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('privacypolicy.index')
                         ->with('success', 'Privacy Policy created successfully.');
    }

    public function edit($id)
    {
        $privacypolicy = Privacypolicy::findOrFail($id);
        return view('admin.privacypolicy.edit', compact('privacypolicy'));
    }

    public function update(Request $request, Privacypolicy $privacypolicy)
    {
        $request->validate([
            'title.en' => 'required|string|max:255',
            'title.bn' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.bn' => 'required|string',
        ]);

        $privacypolicy->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('privacypolicy.index')
                         ->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(Privacypolicy $privacypolicy)
    {
        $privacypolicy->delete();
        return redirect()->route('privacypolicy.index')
                         ->with('success', 'Privacy Policy deleted successfully.');
    }
}
