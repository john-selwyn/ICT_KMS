<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PendingEntries;
use App\Models\Category;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function show($entry)
    {
        $entry = Approval::with('category')->findOrFail($entry);
        return view('show', compact('entry'));
    }

    public function edit($id)
    {
        // Fetch the current entry by ID
        $entry = Approval::findOrFail($id);

        // Fetch all categories from the database
        $categories = Category::all();

        // Pass the entry and categories to the edit view
        return view('edit_approve', compact('entry', 'categories'));
    }


    public function update(Request $request, $entry)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip', // Validate multiple attachments
            'youtube_url' => 'nullable|url',
        ]);

        // Find the entry to update
        $entry = Approval::findOrFail($entry);
        $entry->title = $request->title;
        $entry->description = $request->description;
        $entry->youtube_url = $request->youtube_url;

        // Handle the attachment files (upload to storage and save paths)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $filePath = $attachment->store('uploads', 'public');

                // Save attachment in the approve_attachments table
                $entry->approve_attachments()->create([
                    'file_path' => $filePath, // Store file path in the approve_attachments table
                ]);
            }
        }

        // Save the updated entry
        $entry->save();

        return redirect()->route('entries.approves', ['entry' => $entry->id])->with('success', 'Entry updated successfully!');
    }


    public function destroy($entry)
    {
        $entry = Approval::findOrFail($entry);
        $entry->delete();

        return redirect()->route('entries.approves')->with('success', 'Entry deleted successfully!');
    }

    public function trash($id)
    {
        $entry = Approval::findOrFail($id);
        $entry->delete();

        return redirect()->route('entries.approves')->with('success', 'Entry moved to trash!');
    }

    public function restore($id)
    {
        $entry = Approval::withTrashed()->findOrFail($id);
        $entry->restore();

        return redirect()->route('entries.approves')->with('success', 'Entry restored successfully!');
    }

    public function trashIndex()
    {
        $entries = Approval::all(); // Get all non-trashed entries
        $trashedEntries = Approval::onlyTrashed()->get(); // Get only soft deleted entries

        return view('trash', compact('entries', 'trashedEntries'));
    }

    public function handle()
    {
        Approval::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(30))
            ->forceDelete();

        $this->info('Old trashed entries deleted successfully.');
    }






}
