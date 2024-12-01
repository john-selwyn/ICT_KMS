<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $table = 'approve_entries';  // Matches your database table

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'attachment',
        'youtube_url',
        'thumbnail',
    ];

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

}
