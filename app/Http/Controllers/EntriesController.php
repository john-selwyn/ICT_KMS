<?php

namespace App\Http\Controllers;
use App\Models\PendingEntries;
use App\Models\Approval;
use App\Models\Category;

use Illuminate\Http\Request;

class EntriesController extends Controller
{

    //Approve Entries Section
    public function approve_entries(){
        $entries = Approval::with('category')->get();

        return view('approve_entries', ['entries' => $entries]);
    }

    public function approve($id)
    {
        // Fetch the entry from pending_entries
        $entry = PendingEntries::find($id);
    
        // Check if the entry exists
        if ($entry) {
            // Move the entry to approve_entries table
            $approvedEntry = new Approval();
            $approvedEntry->title = $entry->title;
            $approvedEntry->description = $entry->description;
            $approvedEntry->category_id = $entry->category_id;
            $approvedEntry->attachment = $entry->attachment;
            $approvedEntry->save();
    
            // Delete the entry from pending_entries
            $entry->delete();
    
            // Redirect with success message
            return redirect()->route('entries.approves')->with('success', 'Entry approved successfully.');
        } else {
            // Redirect with error message if entry not found
            return redirect()->back()->with('error', 'Entry not found!');
        }
    }




    //Pending Entries Section
    public function entries(){
        $entries = PendingEntries::with('category')->get();

        return view('entries', ['entries' => $entries]);
    }

    public function create(){
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',  // Ensure this matches the column name
            'attachment' => 'nullable|file|max:204800',
        ]);
    
        $data = $request->only(['title', 'description', 'category_id']); // Use 'category_id' here
    
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            
            // Store the file and get the path
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            
            // Save the path to the database, not just the filename
            $data['attachment'] = $filePath;
        }
    
        PendingEntries::create($data);
        return response()->json(['redirect' => route('entries.pending')]);
    }
    
    public function edit(PendingEntries $entries){
        return view('edit', ['entries' => $entries ]);
    }

    public function update(PendingEntries $entries, Request $request){
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mkv|max:2048',  // max size 2MB
            

        ]);
        $data = $request->only(['title', 'description', 'category_id']);

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $filePath = $request->file('attachment')->store('uploads', 'public');
            $fileName = $request->file('attachment')->getClientOriginalName();


            $data['attachment'] = $filePath;
            
        }
        
        $entries->update($data);
        return redirect(route('entries.pending'))->with('success','Entries Updated Successfully');


    }

    public function delete(PendingEntries $entries){
        $entries->delete();
        return redirect(route('entries.pending'))->with('success','Entries Deleted Successfully');

    }
}
