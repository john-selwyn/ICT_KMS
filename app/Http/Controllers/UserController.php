<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditTrail;
use App\Http\Controllers\AuditTrailController;

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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the creation action
        AuditTrailController::log('Created a new user', auth()->id(), $user->id);

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

        // Capture original details before updating
        $originalName = $user->name;
        $originalEmail = $user->email;

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Log the update action
        AuditTrailController::log(
            "Updated user details (Name: $originalName to {$user->name}, Email: $originalEmail to {$user->email})",
            auth()->id(),
            $user->id
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Log the deletion action before deleting the user
        AuditTrailController::log('Deleted user', auth()->id(), $user->id);

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

        // Log the promotion action
        AuditTrailController::log('Promoted user to admin', auth()->id(), $user->id);

        return back()->with('success', 'User promoted successfully.');
    }

    public function demote(User $user)
    {
        if ($user->role === 'staff') {
            return back()->with('message', 'User is already at the lowest role.');
        }

        $user->role = 'staff';
        $user->save();

        // Log the demotion action
        AuditTrailController::log('Demoted user to staff', auth()->id(), $user->id);

        return back()->with('success', 'User demoted successfully.');
    }

    public function updateRole(Request $request, $id)
    {
        // Validate the role input
        $request->validate([
            'role' => 'required|in:admin,staff',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Capture original role before updating
        $originalRole = $user->role;

        // Update the user's role
        $user->role = $request->input('role');
        $user->save();

        // Log the role update action
        AuditTrailController::log(
            "Updated user role from $originalRole to {$user->role}",
            auth()->id(),
            $user->id
        );

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User role updated successfully!');
    }
}
