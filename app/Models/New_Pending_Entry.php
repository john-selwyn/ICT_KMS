<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class New_Pending_Entry extends Model
{
    use HasFactory;
    protected $table = 'new_pending_entries'; // Define the exact table name here
    protected $fillable = ['title'];

    public function contents()
    {
        return $this->hasMany(EntryContent::class, 'entry_id');
    }
}