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


}
