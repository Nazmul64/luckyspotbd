<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer'   => 'required',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);

        return redirect()->route('faq.index')
            ->with('success', 'FAQ created successfully');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer'   => 'required',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);

        return redirect()->route('faq.index')
            ->with('success', 'FAQ updated successfully');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')
            ->with('success', 'FAQ deleted successfully');
    }
}
