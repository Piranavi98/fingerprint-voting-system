<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;


class ElectionController extends Controller
{
    public function create() {
        return view('admin.elections.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
    
        Election::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request-> start_date,
            'end_date' => $request-> end_date,
             'active' => false,
        ]);
    
        return redirect('/admin/elections')->with('success', 'Election created successfully!');
    }

    public function index()
{
    $elections = Election::all(); // fetch all elections from DB
    return view('admin.elections.index', compact('elections'));
}

public function destroy($id) {
    $elections = Election::findOrFail($id);

    $elections->delete();

    return redirect('/admin/elections')->with('success', 'Election deleted successfully!');
}

public function edit($id)
{
    $election = Election::findOrFail($id);
    return view('admin.elections.edit', compact('election'));
}

// Update election
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $election = Election::findOrFail($id);

    $election->update([
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return redirect('/admin/elections')->with('success', 'Election updated successfully!');
}

public function toggleElection($id)
{
    $election = \App\Models\Election::findOrFail($id);
    $election->active = !$election->active;
    $election->save();

    return back()->with('success', 'Election status updated successfully.');
}


}
