<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Election;

class CandidateController extends Controller
{
    // ================================
    // VIEW ALL CANDIDATES
    // ================================
    public function index() {
        $candidates = Candidate::with('election')->get();
        return view('admin.candidates.index', compact('candidates'));
    }

    // ================================
    // SHOW CREATE FORM
    // ================================
    public function create() {
        $elections = Election::all();
        return view('admin.candidates.create', compact('elections'));
    }

    // ================================
    // STORE NEW CANDIDATE
    // ================================
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'party' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'election_id' => 'required|exists:elections,id',
        ]);

        $filename = null;
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/candidates'), $filename);
        }

        Candidate::create([
            'name' => $request->name,
            'party' => $request->party,
            'image' => $filename,
            'election_id'=> $request->election_id,
        ]);

        return redirect('/admin/candidates')->with('success', 'Candidate added successfully!');
    }

    // ================================
    // SHOW EDIT FORM
    // ================================
    public function edit($id) {
        $candidate = Candidate::findOrFail($id);
        $elections = Election::all(); 
        return view('admin.candidates.edit', compact('candidate', 'elections'));
    }

    // ================================
    // UPDATE CANDIDATE
    // ================================
    public function update(Request $request, $id) {
        $candidate = Candidate::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'party' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png',
        'election_id' => 'required|exists:elections,id',
    ]);

    $filename = $candidate->image;

    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/candidates'), $filename);
    }

    $candidate->update([
        'name' => $request->name,
        'party' => $request->party,
        'image' => $filename,
        'election_id' =>$request->election_id,
    ]);

    return redirect('/admin/candidates')->with('success', 'Candidate updated successfully!');
    }

    // ================================
    // DELETE CANDIDATE
    // ================================
    public function destroy($id) {
        $candidate = Candidate::findOrFail($id);

        // Delete image if exists
        if ($candidate->image && file_exists(public_path('uploads/candidates/' . $candidate->image))) {
            unlink(public_path('uploads/candidates/' . $candidate->image));
        }

        $candidate->delete();

        return redirect('/admin/candidates')->with('success', 'Candidate deleted successfully!');
    }
}
