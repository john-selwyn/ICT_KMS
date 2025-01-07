<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Approval extends Model
{
    use HasFactory, SoftDeletes; // Enable SoftDeletes trait

    protected $table = 'approve_entries';  // Matches your database table

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'attachment',
        'youtube_url',
        'thumbnail',
        'views',
    ];

    protected $dates = ['deleted_at']; // To handle soft delete timestamps

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Define the relationship with the Approve_Attachments model.
     */
    public function approve_attachments()
    {
        return $this->hasMany(ApproveAttachment::class, 'approve_entry_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_entry', 'approved_entries_id', 'category_id');
    }

}
