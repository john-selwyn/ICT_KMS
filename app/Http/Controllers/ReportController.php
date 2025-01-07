<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch category data with the count of entries per category
        $categoryData = Approval::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->with('category')
            ->get();


        $popularEntries = Approval::orderBy('views', 'desc')
            ->take(10)
            ->get();

        return view('reports.index', compact('categoryData', 'popularEntries'));
    }

    public function export()
    {
        // Fetch category data with entry count and total views
        $entries = DB::table('categories')
            ->leftJoin('approve_entries', 'categories.id', '=', 'approve_entries.category_id')
            ->select('categories.name as category_name', DB::raw('COUNT(approve_entries.id) as entry_count'), DB::raw('SUM(approve_entries.views) as total_views'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Fetch top 10 popular entries based on views
        $popularEntries = DB::table('approve_entries')
            ->select('title', 'views')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        // CSV header
        $csv = "Category,Entries Count,Total Views\n";

        // Add category data rows to CSV
        foreach ($entries as $entry) {
            $csv .= "{$entry->category_name},{$entry->entry_count},{$entry->total_views}\n";
        }

        // Add a separator for clarity
        $csv .= "\nMost Popular Entries\nTitle,Views\n";

        // Add popular entries data rows to CSV
        foreach ($popularEntries as $entry) {
            $csv .= "{$entry->title},{$entry->views}\n";
        }

        $fileName = 'category_report_with_popularity.csv';
        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }

}
