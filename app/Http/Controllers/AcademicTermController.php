<?php

namespace App\Http\Controllers;

use App\Models\AcademicTerm;
use Illuminate\Http\Request;

class AcademicTermController extends Controller
{
    public function index()
    {
        $academicterms = AcademicTerm::orderBy('term_start', 'desc')->paginate(10);
        return view('academicterm.index', compact('academicterms'));
    }

    public function create()
    {
        return view('academicterm.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'term' => 'required|string|max:50',
            'year' => 'required|string|max:20',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after_or_equal:term_start',
            'is_active' => 'required|boolean',
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];

        if ($validated['is_active']) {
            AcademicTerm::where('is_active', true)->update(['is_active' => false]);
        }

        AcademicTerm::create($validated);

        return redirect()->route('academicterm.index')->with('success', 'Academic term created.');
    }

    public function show(AcademicTerm $academicterm)
    {
        return view('academicterm.show', compact('academicterm'));
    }

    public function edit(AcademicTerm $academicterm)
    {
        return view('academicterm.edit', compact('academicterm'));
    }

    public function update(Request $request, AcademicTerm $academicterm)
    {


        $validated = $request->validate([
            'term' => 'required|string|max:50',
            'year' => 'required|string|max:20',
            'term_start' => 'required|date',
            'term_end' => 'required|date|after_or_equal:term_start',
            'is_active' => 'sometimes|boolean',
        ]);
        $validated['is_active'] = (bool) $validated['is_active'];

        if ($validated['is_active']) {
            AcademicTerm::where('id', '!=', $academicterm->id)
                        ->where('is_active', true)
                        ->update(['is_active' => false]);
        }



        $academicterm->update($validated);

        return redirect()->route('academicterm.show', $academicterm)
                         ->with('success', 'Academic term updated.');
    }

    public function destroy(AcademicTerm $academicterm)
    {
        $academicterm->delete();
        return redirect()->route('academicterm.index')->with('success', 'Academic term deleted.');
    }
}
