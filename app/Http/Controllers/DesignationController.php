<?php
namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::withCount('users')->get();
        return view('designations.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:designations,name']);
        Designation::create(['name' => $request->name]);
        return back()->with('success', 'Designation added.');
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate(['name' => 'required|string|unique:designations,name,' . $designation->id]);
        $designation->update(['name' => $request->name]);
        return back()->with('success', 'Designation updated.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return back()->with('success', 'Designation deleted.');
    }
}