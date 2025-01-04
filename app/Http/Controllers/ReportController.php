<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PendingEntries;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EntriesExport;

class ReportController extends Controller
{
    public function index()
    {
        // Summary analytics
        $approvedCount = Approval::count();
        $pendingCount = PendingEntries::count();
        $topCategories = Approval::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('reports.index', compact('approvedCount', 'pendingCount', 'topCategories'));
    }

    public function export(Request $request)
    {
        $format = $request->input('format', 'xlsx');

        if ($format == 'xlsx') {
            return Excel::download(new EntriesExport, 'entries_report.xlsx');
        } elseif ($format == 'pdf') {
            $entries = Approval::all();
            $pdf = \PDF::loadView('reports.pdf', compact('entries'));
            return $pdf->download('entries_report.pdf');
        }
    }


}
