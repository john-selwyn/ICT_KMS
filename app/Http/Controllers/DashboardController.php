<?php
namespace App\Http\Controllers;

use App\Models\PendingEntries;
use App\Models\Approval;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the necessary counts
        $categoryCount = Category::count();
        $userCount = User::count();
        $approve_entriesCount = Approval::count();
        $pending_entriesCount = PendingEntries::count();
        
        // Fetch latest entries and categories with approvals count
        $categories = Category::withCount('approvals')->get();
        $entries = Approval::latest()->take(5)->get();

        return view('dashboard', compact('categories', 'entries', 'categoryCount', 'userCount', 'approve_entriesCount', 'pending_entriesCount'));
    }

    public function show($id)
    {
        $item = Approval::find($id);

        if (!$item) {
            return redirect()->route('entries.pending')->with('error', 'Item not found.');
        }

        return view('item_detail', compact('item'));
    }

    public function showItems2($categoryId, $itemId = null)
    {
        $category = Category::findOrFail($categoryId);
        $items = Approval::where('category_id', $categoryId)->get();
        $item = $itemId ? Approval::where('category_id', $categoryId)->find($itemId) : null;

        return view('category_items', compact('category', 'items', 'item'));
    }

    public function list()
    {
        // Fetch the necessary counts
        $categoryCount = Category::count();
        $userCount = User::count();
        
        // Fetch latest entries and categories with approvals count
        $categories = Category::withCount('approvals')->get();
        $entries = Approval::latest()->take(5)->get();

        return view('category_list', compact('categories', 'entries', 'categoryCount', 'userCount'));
    }
}
