<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $table = 'approve_entries';  // Make sure this matches your DB table

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'attachment',
        'thumbnail',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
