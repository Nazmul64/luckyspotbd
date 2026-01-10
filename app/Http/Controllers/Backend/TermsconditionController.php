<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Termscondition;
use Illuminate\Http\Request;

class TermsconditionController extends Controller
{
    public function index()
    {
        $termsconditions = Termscondition::all();
        return view('admin.termscondition.index', compact('termsconditions'));
    }

    public function create()
    {
        return view('admin.termscondition.create');
    }

 public function store(Request $request)
{
    $request->validate([
        'title.en' => 'required|string|max:255',
        'title.bn' => 'required|string|max:255',
        'description.en' => 'required|string',
        'description.bn' => 'required|string',
    ]);

    Termscondition::create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('Termscondition.index')
                     ->with('success', 'Terms & Conditions created successfully.');
}




    public function edit($id)
    {
        $termscondition = Termscondition::findOrFail($id);
        return view('admin.termscondition.edit', compact('termscondition'));
    }

    public function update(Request $request, $id)
    {
        $termscondition = Termscondition::findOrFail($id);

        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_bn' => 'required|string',
        ]);

        $termscondition->update([
            'title' => [
                'en' => $request->title_en,
                'bn' => $request->title_bn,
            ],
            'description' => [
                'en' => $request->description_en,
                'bn' => $request->description_bn,
            ],
        ]);

        return redirect()->route('Termscondition.index')->with('success', 'Terms & Conditions updated successfully.');
    }

    public function destroy($id)
    {
        $termscondition = Termscondition::findOrFail($id);
        $termscondition->delete();

        return redirect()->route('Termscondition.index')->with('success', 'Terms & Conditions deleted successfully.');
    }
}
