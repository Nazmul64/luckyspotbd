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
        'title_en' => 'nullable|string',
        'title_bn' => 'nullable|string',
        'description_en' => 'nullable|string',
        'description_bn' => 'nullable|string',
        'question_en' => 'required|string',
        'question_bn' => 'required|string',
        'answer_en' => 'required|string',
        'answer_bn' => 'required|string',
    ]);

    Faq::create([
        'title' => [
            'en' => $request->title_en,
            'bn' => $request->title_bn,
        ],
        'description' => [
            'en' => $request->description_en,
            'bn' => $request->description_bn,
        ],
        'question' => [
            'en' => $request->question_en,
            'bn' => $request->question_bn,
        ],
        'answer' => [
            'en' => $request->answer_en,
            'bn' => $request->answer_bn,
        ],
    ]);

    return redirect()->route('faq.index')->with('success', 'FAQ created successfully.');
}


    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
{
    $request->validate([
        'title_en'       => 'nullable|string',
        'title_bn'       => 'nullable|string',
        'description_en' => 'nullable|string',
        'description_bn' => 'nullable|string',
        'question_en'    => 'required|string|max:255',
        'question_bn'    => 'required|string|max:255',
        'answer_en'      => 'required|string',
        'answer_bn'      => 'required|string',
    ]);

    $faq->update([
        'title' => [
            'en' => $request->title_en,
            'bn' => $request->title_bn,
        ],
        'description' => [
            'en' => $request->description_en,
            'bn' => $request->description_bn,
        ],
        'question' => [
            'en' => $request->question_en,
            'bn' => $request->question_bn,
        ],
        'answer' => [
            'en' => $request->answer_en,
            'bn' => $request->answer_bn,
        ],
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
