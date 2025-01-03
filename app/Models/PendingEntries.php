<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingEntries extends Model
{
    use HasFactory;

    protected $table = 'pending_entries';
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'attachment',
        'youtube_url',
        'created_by',
        'user_id',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'pending_entry_id');
    }

    public function categories()
{
    return $this->belongsToMany(Category::class, 'category_entry', 'pending_entries_id', 'category_id');
}



}
