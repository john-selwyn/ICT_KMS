<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditTrail;
use App\Http\Controllers\AuditTrailController;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // File: app/Http/Controllers/UserController.php



    public function destroy(User $user)
    {
        // Capture user details if needed for the audit trail
        $userId = $user->id;  // Capture ID before deletion
        $userName = $user->name;  // Example: capturing the name if needed

        // Log the deletion action before deleting the user
        AuditTrailController::log('Deleted user', auth()->id(), $userId);

        // Additional details can be logged as needed
        // AuditTrailController::log('Deleted user ' . $userName, auth()->id(), $userId);

        // Delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }







    public function promote(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('message', 'User is already an admin.');
        }

        $user->role = 'admin';
        $user->save();

        AuditTrail::create([
            'action' => 'Promoted user to admin',
            'performed_by' => Auth::id(),
            'affected_user_id' => $user->id,
        ]);

        return back()->with('success', 'User promoted successfully.');
    }

    public function demote(User $user)
    {
        if ($user->role === 'staff') {
            return back()->with('message', 'User is already at the lowest role.');
        }

        $user->role = 'staff';
        $user->save();

        AuditTrail::create([
            'action' => 'Demoted user to staff',
            'performed_by' => Auth::id(),
            'affected_user_id' => $user->id,
        ]);

        return back()->with('success', 'User demoted successfully.');
    }
}
