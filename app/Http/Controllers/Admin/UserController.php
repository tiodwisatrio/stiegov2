<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user();
        
        // Developer can see all users
        if ($currentUser->isDeveloper()) {
            $users = User::latest()->paginate(20);
        } 
        // Admin can only see customers
        else {
            $users = User::where('role', 'customer')->latest()->paginate(20);
        }
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = auth()->user();
        
        // Available roles based on current user
        if ($currentUser->isDeveloper()) {
            $roles = ['customer', 'admin', 'developer'];
        } else {
            $roles = ['customer']; // Admin can only create customers
        }
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        
        // Validation rules
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:customer,admin,developer'],
        ]);
        
        // Check authorization
        if (!$currentUser->isDeveloper() && $validated['role'] !== 'customer') {
            abort(403, 'Unauthorized. Only developers can create admin/developer accounts.');
        }
        
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
        
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $currentUser = auth()->user();
        
        // Admin cannot view admin/developer accounts
        if (!$currentUser->isDeveloper() && $user->hasAdminAccess()) {
            abort(403, 'Unauthorized.');
        }
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        
        // Admin cannot edit admin/developer accounts
        if (!$currentUser->isDeveloper() && $user->hasAdminAccess()) {
            abort(403, 'Unauthorized.');
        }
        
        // Available roles based on current user
        if ($currentUser->isDeveloper()) {
            $roles = ['customer', 'admin', 'developer'];
        } else {
            $roles = ['customer'];
        }
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        
        // Admin cannot update admin/developer accounts
        if (!$currentUser->isDeveloper() && $user->hasAdminAccess()) {
            abort(403, 'Unauthorized.');
        }
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:customer,admin,developer'],
        ];
        
        // Password is optional on update
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }
        
        $validated = $request->validate($rules);
        
        // Check authorization for role change
        if (!$currentUser->isDeveloper() && $validated['role'] !== 'customer') {
            abort(403, 'Unauthorized. Only developers can assign admin/developer roles.');
        }
        
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        
        // Cannot delete yourself
        if ($user->id === $currentUser->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }
        
        // Admin cannot delete admin/developer accounts
        if (!$currentUser->isDeveloper() && $user->hasAdminAccess()) {
            abort(403, 'Unauthorized. Only developers can delete admin accounts.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
