<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show form for creating a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a new user
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

    // Show form for editing a user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user details
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

    // Delete a user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function promote(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('message', 'User is already an admin.');
        }

        // Update user role to a higher level, e.g., 'admin'
        $user->role = 'admin'; // or however your roles are structured
        $user->save();

        return back()->with('success', 'User promoted successfully.');
    }

    public function demote(User $user)
    {
        if ($user->role === 'staff') {
            return back()->with('message', 'User is already at the lowest role.');
        }


        // Update user role to a lower level, e.g., 'user'
        $user->role = 'staff';
        $user->save();

        return back()->with('success', 'User demoted successfully.');
    }

}
