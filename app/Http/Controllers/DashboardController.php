<?php

namespace App\Http\Controllers;

use App\Models\PendingEntries;
use App\Models\Approval;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('approvals')->get(); // Assuming 'entries' is the relationship name for entries belonging to a category
        $entries = Approval::latest()->take(5)->get();

        return view('dashboard', compact('categories', 'entries'));
    }

    public function show($id)
{
    // Attempt to find the item based on the ID
    $item = Approval::find($id);

    // Check if the item exists; if not, return with an error message
    if (!$item) {
        return redirect()->route('entries.pending')->with('error', 'Item not found.');
    }

    // Pass the found item to the view
    return view('item_detail', compact('item'));
}

public function showItems2($categoryId, $itemId = null)
{
    $category = Category::findOrFail($categoryId);
    $items = Approval::where('category_id', $categoryId)->get();
    $item = $itemId ? Approval::where('category_id', $categoryId)->find($itemId) : null;

    return view('category_items', compact('category', 'items', 'item'));
}





}
