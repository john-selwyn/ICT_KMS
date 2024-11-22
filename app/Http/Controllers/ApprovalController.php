<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\PendingEntries;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function show($entry)
    {
        $entry = Approval::with('category')->findOrFail($entry);
        return view('show', compact('entry'));
    }

    public function edit($entry)
    {
        $entry = Approval::findOrFail($entry);
        return view('edit_approve', compact('entry'));
    }

    public function update(Request $request, $entry)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip',
            'youtube_url' => 'nullable|url' // Validate as a URL if it exists
            
        ]);

        $entry = Approval::findOrFail($entry);
        $entry->title = $request->title;
        $entry->description = $request->description;

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('uploads', 'public');
            $entry->attachment = $filePath;
        }

         // Save YouTube URL to the entry
         $entry->youtube_url = $request->youtube_url;

        $entry->save();

        return redirect()->route('entries.approves', ['entry' => $entry->id])->with('success', 'Entry updated successfully!');
    }

    public function destroy($entry)
    {
        $entry = Approval::findOrFail($entry);
        $entry->delete();

        return redirect()->route('entries.approves')->with('success', 'Entry deleted successfully!');
    }
}
