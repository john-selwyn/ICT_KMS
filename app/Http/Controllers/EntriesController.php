<?php

namespace App\Http\Controllers;
use App\Models\PendingEntries;
use App\Models\Approval;
use App\Models\Category;
use App\Models\Attachments;
use App\Models\ApproveAttachment;

use Illuminate\Http\Request;

class EntriesController extends Controller
{

    //Approve Entries Section
    public function approve_entries()
    {
        $entries = Approval::with('category')->get();

        return view('approve_entries', ['entries' => $entries]);
    }

    public function approve($id)
    {
        // Fetch the entry from pending_entries with attachments
        $entry = PendingEntries::with('attachments')->find($id);

        // Check if the entry exists
        if ($entry) {
            // Move the entry to approve_entries table
            $approvedEntry = Approval::create([
                'title' => $entry->title,
                'description' => $entry->description,
                'category_id' => $entry->category_id,
                'youtube_url' => $entry->youtube_url,
                // 'thumbnail' => $entry->thumbnail, // Include if necessary
            ]);

            // Move attachments to approve_attachments table
            foreach ($entry->attachments as $attachment) {
                ApproveAttachment::create([
                    'approve_entry_id' => $approvedEntry->id,
                    'file_path' => $attachment->file_path,
                ]);

                // Optionally, delete the attachment from the attachments table
                $attachment->delete();
            }

            // Delete the entry from pending_entries
            $entry->delete();

            // Redirect with success message
            return redirect()->route('entries.approves')->with('success', 'Entry approved successfully.');
        } else {
            // Redirect with error message if entry not found
            return redirect()->back()->with('error', 'Entry not found!');
        }
    }


    public function search(Request $request)
    {
        $query = $request->input('search'); // Get the search query from the request

        $entries = Approval::when($query, function ($q) use ($query) {
            // Search by title, description, or category name
            $q->where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orWhereHas('category', function ($catQuery) use ($query) {
                    $catQuery->where('name', 'like', '%' . $query . '%');
                });
        })->get();

        return view('approve_entries', compact('entries'));
    }





    //Pending Entries Section
    public function entries()
    {
        $entries = PendingEntries::with('category')->get();
        return view('entries', ['entries' => $entries]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:204800', // Validate each file
            'youtube_url' => 'nullable|url',
        ]);

        // Create pending entry
        $pendingEntry = PendingEntries::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'youtube_url' => $validatedData['youtube_url'] ?? null,
        ]);

        // Handle multiple file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->storeAs(
                    'uploads', // Directory
                    $file->getClientOriginalName(), // Original filename
                    'public' // Storage disk
                );

                // Save each file in the attachments table
                Attachments::create([
                    'pending_entry_id' => $pendingEntry->id, // Link to pending entry
                    'file_path' => $filePath, // File path
                ]);
            }
        }

        // Redirect to pending entries list with success message
        return redirect(route('entries.pending'))->with('success', 'Entry created successfully!');
    }





    public function edit(PendingEntries $entries)
    {
        return view('edit', ['entries' => $entries]);
    }

    public function update(PendingEntries $entries, Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mkv|max:2048',  // max size 2MB
            'youtube_url' => 'nullable|url',  // Validate YouTube URL as optional


        ]);
        $data = $request->only(['title', 'description', 'category_id', 'youtube_url']);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $request->file('attachment')->store('uploads', 'public');
            $fileName = $request->file('attachment')->getClientOriginalName();


            $data['attachment'] = $filePath;

        }

        $entries->update($data);
        return redirect(route('entries.pending'))->with('success', 'Entries Updated Successfully');


    }

    public function delete(PendingEntries $entries)
    {
        $entries->delete();
        return redirect(route('entries.pending'))->with('success', 'Entries Deleted Successfully');

    }

    public function show_pending($id)
    {
        /*
        $entry = PendingEntries::with('category')->findOrFail($entry);
        return view('show_pending', compact('entry'));
        */
        // Fetch the pending entry along with its attachments
        $entry = PendingEntries::with('attachments', 'category')->findOrFail($id);

        // Pass the entry (with attachments) to the view
        return view('show_pending', compact('entry'));
    }
}
