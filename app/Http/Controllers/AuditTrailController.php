<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;
use App\Models\User;

class AuditTrailController extends Controller
{
    /**
     * Display a listing of the audit trails.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditTrails = AuditTrail::with(['performedByUser', 'affectedUser'])->latest()->get();
        return view('admin.audit_trails.index', compact('auditTrails'));
    }


    /**
     * Store a newly created audit trail in storage.
     *
     * @param  string  $action
     * @param  int  $performedById
     * @param  int|null  $affectedUserId
     * @return void
     */
    // File: app/Http/Controllers/AuditTrailController.php

    public static function log($action, $performedById, $affectedUserId = null)
    {
        $performedByUser = User::find($performedById);
        $affectedUser = $affectedUserId ? User::find($affectedUserId) : null;

        AuditTrail::create([
            'action' => $action,
            'performed_by_user_id' => $performedById,
            'performed_by_user_name' => $performedByUser ? $performedByUser->name : null,
            'affected_user_id' => $affectedUserId,
            'affected_user_name' => $affectedUser ? $affectedUser->name : null,
        ]);
    }



}
