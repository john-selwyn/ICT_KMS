<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Approval;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch categories with the count of approved entries
        $categoryData = Category::withCount(['approvedEntries', 'pendingEntries'])->get();

        // Fetch top popular approved entries
        $popularEntries = Approval::select('title', 'views')
            ->orderBy('views', 'desc')
            ->take(5) // Adjust the number of popular entries to display
            ->get();

        return view('reports.index', compact('categoryData', 'popularEntries'));
    }

    public function export()
{
    // Fetch categories with only approved entries count
    $categoryData = Category::withCount('approvedEntries')->get();

    // Fetch top popular approved entries
    $popularEntries = Approval::select('title', 'views')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();

    // Prepare CSV content
    $csv = "Category,Approved Entries\n"; // Header without pending entries
    foreach ($categoryData as $category) {
        $csv .= "{$category->name},{$category->approved_entries_count}\n";
    }

    $csv .= "\nTitle,Views\n"; // Section for popular entries
    foreach ($popularEntries as $entry) {
        $csv .= "{$entry->title},{$entry->views}\n";
    }

    // Return the CSV file
    return response($csv)
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', 'attachment; filename="report.csv"');
}

}
