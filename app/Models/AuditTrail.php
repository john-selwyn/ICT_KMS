<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = ['action', 'performed_by_user_id', 'performed_by_user_name', 'affected_user_id', 'affected_user_name'];


    public function performedByUser()
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }

    public function affectedUser()
    {
        return $this->belongsTo(User::class, 'affected_user_id');
    }
}

