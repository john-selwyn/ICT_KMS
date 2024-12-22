<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PendingEntries;
use App\Models\Category;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function viewTrash($id)
    {
        $entry = Approval::onlyTrashed()->findOrFail($id); // Retrieve the trashed entry by ID
        return view('trash.view', compact('entry')); // Pass the $entry variable to the view
    }
    public function destroy($id)
{
    // Retrieve the trashed entry
    $entry = Approval::onlyTrashed()->find($id);

    if ($entry) {
        $entry->forceDelete(); // Permanently delete the entry
        return redirect()->route('entries.trash.index')->with('success', 'Entry permanently deleted.');
    }

    return redirect()->route('entries.trash.index')->with('error', 'Entry not found.');
}



}
