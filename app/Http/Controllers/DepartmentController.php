<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
    $departments = Department::orderBy('department_name')->get();

    return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_code' => 'required|string|unique:departments,department_code',
            'department_name' => 'required|string',
            'department_coordinates' => 'required|string',
            'department_radius_in_meters' => 'required|integer|min:0',
        ]);

        Department::create($validated);

        return redirect()->route('dashboard')->with('success', 'Department added successfully');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted.');
    }
}
