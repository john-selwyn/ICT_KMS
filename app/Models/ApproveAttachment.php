<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveAttachment extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'approve_attachments';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'file_path',        // Path to the stored file 
        'approve_entry_id', // Foreign key referencing approve_entries table
    ];

    /**
     * Define the relationship to the Approval model.
     */
    public function approval()
    {
        return $this->belongsTo(Approval::class, 'approve_entry_id');
    }

}
