<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use PDF; // for PDF export
use Maatwebsite\Excel\Facades\Excel; // for CSV export
use App\Exports\ElectionResultsExport;

class ResultController extends Controller
{
    // Show election results
    public function index()
    {
        $elections = \App\Models\Election::with('candidates.votes', 'voters')->get();
        return view('admin.results.index', compact('elections'));
    }

    // Export as PDF
    public function exportPdf($id)
    {
        $election = Election::with('candidates.votes')->findOrFail($id);
        $pdf = PDF::loadView('admin.results.pdf', compact('election'));
        return $pdf->download($election->title.'_results.pdf');
    }

    // Export as CSV
    public function exportCsv($id)
    {
        return Excel::download(new ElectionResultsExport($id), 'election_'.$id.'_results.csv');
    }

    public function viewResults()
{
    $elections = \App\Models\Election::with('candidates.votes')->get();

    return view('admin.results.index', compact('elections'));
}
}
