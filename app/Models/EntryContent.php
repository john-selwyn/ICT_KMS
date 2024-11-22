<?php

// app/Models/EntryContent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryContent extends Model
{
    use HasFactory;
    protected $table = 'entry_content'; // Define the exact table name here
    protected $fillable = ['entry_id', 'content_type', 'content_text', 'content_url'];

    public function entry()
    {
        return $this->belongsTo(New_Pending_Entry::class, 'entry_id');
    }
}
