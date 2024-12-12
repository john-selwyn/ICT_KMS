<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;


    // The table associated with the model
    protected $table = 'attachments';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'file_path',        // Path to the stored file 
        'pending_entry_id', // Foreign key to the pending_entries table
        'original_name',
    ];

    /**
     * Define a relationship to the PendingEntries model.
     */
    public function pendingEntry()
    {
        return $this->belongsTo(PendingEntries::class, 'pending_entry_id');
    }

    public function approvedEntry()
    {
        return $this->belongsTo(Approval::class, 'approve_entry_id');
    }

}
