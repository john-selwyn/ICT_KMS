<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if the table follows Laravel's naming convention)
    protected $table = 'categories';

    // Specify the fields that are mass assignable
    protected $fillable = ['name'];

    // Define the relationship to knowledge base entries (if each category has multiple knowledge base entries)
    public function pendingEntries()
    {
        return $this->hasMany(PendingEntries::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function items()
    {
        return $this->hasMany(Approval::class, 'category_id');
    }
}
