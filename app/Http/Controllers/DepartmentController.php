<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentFunction;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('functions')->withCount('users')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|unique:departments,name',
            'functions' => 'required|array|min:1',
            'functions.*' => 'required|string|max:100',
        ]);

        $dept = Department::create(['name' => $request->name]);

        foreach ($request->functions as $func) {
            if (trim($func)) {
                DepartmentFunction::create([
                    'department_id' => $dept->id,
                    'name'          => trim($func),
                ]);
            }
        }

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $department->load('functions');
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name'        => 'required|string|unique:departments,name,' . $department->id,
            'functions'   => 'required|array|min:1',
            'functions.*' => 'required|string|max:100',
        ]);

        $department->update(['name' => $request->name]);

        // Sync functions
        $department->functions()->delete();
        foreach ($request->functions as $func) {
            if (trim($func)) {
                DepartmentFunction::create([
                    'department_id' => $department->id,
                    'name'          => trim($func),
                ]);
            }
        }

        return redirect()->route('departments.index')
            ->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return back()->with('success', 'Department deleted.');
    }

    // API endpoint for dynamic function dropdown
    public function functions(Department $department)
    {
        return response()->json($department->functions);
    }
}