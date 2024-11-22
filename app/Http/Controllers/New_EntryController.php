<?php

// app/Http/Controllers/New_EntryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\New_Pending_Entry;
use App\Models\EntryContent;

class New_EntryController extends Controller
{
    public function create()
    {
        return view('new_entry.create');
    }

        public function new_store(Request $request)
    {
        $entry = New_Pending_Entry::create(['title' => $request->title]);

        foreach ($request->contents as $content) {
            // Ensure 'type' key exists in content
            if (!isset($content['type'])) { 
                continue; // Skip this iteration if 'type' is not set
            }

            if ($content['type'] == 'text') {
                // Check if 'text' key exists in content
                EntryContent::create([
                    'entry_id' => $entry->id,
                    'content_type' => 'text',
                    'content_text' => $content['text'] ?? '', // Use default value if 'text' is missing
                ]);
            } elseif ($content['type'] == 'image' || $content['type'] == 'attachment') {
                // Ensure 'file' key exists in content
                if (isset($content['file']) && $content['file']->isValid()) {
                    $filePath = $content['file']->store('uploads', 'public');
                    EntryContent::create([
                        'entry_id' => $entry->id,
                        'content_type' => $content['type'],
                        'content_url' => $filePath,
                    ]);
                }
            }
        }

        return redirect()->route('new_entry.create')->with('success', 'Entry created successfully!');
    }


    public function showEntries()
    {
        // Retrieve all entries with their related contents
        $entries = New_Pending_Entry::with('contents')->get();

        return view('new_entry.show_entries', compact('entries'));
    }
}
