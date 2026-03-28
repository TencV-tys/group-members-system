<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // Public view (card layout)
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    // Admin table view (for sidebar "All Members")
    public function adminTableView()
    {
        $members = Member::all();
        return view('admin.members.table-view', compact('members'));
    }

    // Admin management view (with CRUD)
    public function adminIndex()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'age' => 'required|integer|min:1|max:150',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:8'
    ]);

    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $validated['profile_photo'] = $path;
    }

    $member = Member::create($validated);
    
    // Create user account for the member with the provided password
    User::create([
        'name' => $member->first_name . ' ' . $member->last_name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
        'member_id' => $member->id
    ]);

    return response()->json(['success' => true, 'message' => 'Member created successfully']);
}

   public function edit(Member $member)
{
    // Load the user relationship
    $member->load('user');
    
    // Return JSON with member data including user info
    return response()->json([
        'id' => $member->id,
        'first_name' => $member->first_name,
        'last_name' => $member->last_name,
        'role' => $member->role,
        'age' => $member->age,
        'bio' => $member->bio, 
        'profile_photo' => $member->profile_photo,
        'created_at' => $member->created_at,
        'user' => $member->user ? [
            'email' => $member->user->email,
            'username' => $member->user->username,
        ] : null
    ]);
}
public function update(Request $request, Member $member)
{
    try {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'age' => 'required|integer|min:1|max:150',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email,' . ($member->user ? $member->user->id : 'NULL'),
            'username' => 'required|string|unique:users,username,' . ($member->user ? $member->user->id : 'NULL'),
            'password' => 'nullable|string|min:8'
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($member->profile_photo) {
                Storage::disk('public')->delete($member->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $member->update($validated);
        
        // Update the associated user account
        if ($member->user) {
            $userData = [
                'name' => $member->first_name . ' ' . $member->last_name,
                'username' => $request->username,
                'email' => $request->email,
            ];
            
            // Update password only if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $member->user->update($userData);
        } 

        return response()->json(['success' => true, 'message' => 'Member updated successfully']);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'errors' => $e->getMessage()], 422);
    }
}

    public function destroy(Member $member)
    {
        // Also delete the associated user account
        if ($member->user) {
            $member->user->delete();
        }
        
        if ($member->profile_photo) {
            Storage::disk('public')->delete($member->profile_photo);
        }
        
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully');
    }
}