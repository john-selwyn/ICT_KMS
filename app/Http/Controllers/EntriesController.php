<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



use App\Models\PendingEntries;
use App\Models\Approval;
use App\Models\Category;
use App\Models\Attachments;
use App\Models\ApproveAttachment;



use Illuminate\Http\Request;

class EntriesController extends Controller
{

    //Approve Entries Section

    public function approve_entries(Request $request)
    {
        // Fetch all categories for the dropdown
        $categories = Category::all();

        // Filter entries based on category and/or search query
        $query = Approval::with('approve_attachments', 'category');
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%'); // Example search condition
        }
        $entries = $query->get();


        // Return the view with filtered entries and categories
        return view('approve_entries', [

            'entries' => $entries,
            'categories' => $categories,
        ]);


    }




    public function approve($id)
    {
        // Fetch the pending entry with attachments and categories
        $entry = PendingEntries::with('attachments', 'categories')->findOrFail($id);

        // Move the entry to the approved_entries table
        $approvedEntry = Approval::create([
            'title' => $entry->title,
            'description' => $entry->description,
            'youtube_url' => $entry->youtube_url,
            // Add other necessary fields
        ]);

        // Transfer categories
        foreach ($entry->categories as $category) {
            DB::table('category_entry')->insert([
                'category_id' => $category->id,
                'approved_entries_id' => $approvedEntry->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Transfer attachments
        foreach ($entry->attachments as $attachment) {
            ApproveAttachment::create([
                'approve_entry_id' => $approvedEntry->id,
                'file_path' => $attachment->file_path,
                'original_name' => $attachment->original_name,
            ]);

            $attachment->delete(); // Optionally delete the attachment
        }

        // Delete category relationships for the pending entry
        DB::table('category_entry')->where('pending_entries_id', $entry->id)->delete();

        // Delete the pending entry
        $entry->delete();

        return redirect()->route('entries.approves')->with('success', 'Entry approved successfully.');
    }




    public function search(Request $request)
    {
        $query = $request->input('search');
        $categories = Category::all(); // Ensure categories are fetched for the dropdown

        $entries = Approval::when($query, function ($q) use ($query) {
            $q->where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orWhereHas('category', function ($catQuery) use ($query) {
                    $catQuery->where('name', 'like', '%' . $query . '%');
                });
        })->get();

        return view('approve_entries', compact('entries', 'categories'));
    }






    //Pending Entries Section
    public function entries()
    {
        // Check if the user is staff
        if (auth()->user()->role === 'staff') {
            // Fetch entries created by the current staff user
            $entries = PendingEntries::where('created_by', auth()->id())->with('category')->get();
        } else {
            // Fetch all entries for other roles (e.g., admin)
            $entries = PendingEntries::with('category')->get();
        }

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
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:204800',
            'youtube_url' => 'nullable|url',
        ]);

        // Check if the title already exists in approved entries
        $duplicateTitle = Approval::where('title', $validatedData['title'])->first();

        // Check if the description already exists in approved entries
        $duplicateDescription = Approval::where('description', $validatedData['description'])->first();

        // If the title exists
        if ($duplicateTitle) {
            return redirect()->back()->withErrors([
                'error' => 'An entry with the same title already exists in approved entries.',
            ])->withInput();
        }

        // If the description exists
        if ($duplicateDescription) {
            return redirect()->back()->withErrors([
                'error' => 'An entry with the same description already exists in approved entries.',
            ])->withInput();
        }

        // Create the pending entry
        $pendingEntry = PendingEntries::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'youtube_url' => $validatedData['youtube_url'] ?? null,
            'created_by' => Auth::id(),
            'user_id' => Auth::id(),
        ]);

        // Attach multiple categories to the pending entry
        $pendingEntry->categories()->attach($validatedData['categories']);

        // Handle multiple file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->storeAs(
                    'uploads',
                    $file->getClientOriginalName(),
                    'public'
                );

                Attachments::create([
                    'pending_entry_id' => $pendingEntry->id,
                    'file_path' => $filePath,
                    'original_name' => $file->getClientOriginalName(),
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

    public function entry_edit($id)
    {
        $entry = PendingEntries::findOrFail($id); // Find the pending entry
        $categories = Category::all(); // Fetch categories for dropdown
        $attachments = Attachments::where('pending_entry_id', $id)->get(); // Get attachments for the entry

        return view('edit_pending', compact('entry', 'categories', 'attachments'));
    }


    public function entry_update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|array|min:1', // Validate categories as an array
            'categories.*' => 'exists:categories,id', // Each category must exist in the database
            'youtube_url' => 'nullable|url',
            'attachments.*' => 'nullable|file|max:20048',
        ]);

        $entry = PendingEntries::findOrFail($id);

        // Update basic fields
        $entry->update([
            'title' => $request->title,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
        ]);

        // Sync categories using pivot table
        $entry->categories()->sync($request->categories);

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filePath = $file->storeAs('attachments', $file->getClientOriginalName(), 'public');
                Attachments::create([
                    'pending_entry_id' => $entry->id,
                    'file_path' => $filePath,
                ]);
            }
        }

        // Handle removing attachments
        if ($request->has('removed_attachments')) {
            foreach ($request->removed_attachments as $removedId) {
                $attachment = Attachments::findOrFail($removedId);
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
        }

        return redirect()->route('entries.pending')->with('success', 'Entry updated successfully!');
    }







}
