<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

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
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        Member::create($validated);

        return response()->json(['success' => true, 'message' => 'Member created successfully']);
    }

    public function edit(Member $member)
    {
        return response()->json($member);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'age' => 'required|integer|min:1|max:150',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($member->profile_photo) {
                Storage::disk('public')->delete($member->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $member->update($validated);

        return response()->json(['success' => true, 'message' => 'Member updated successfully']);
    }

    public function destroy(Member $member)
    {
        // Delete profile photo if exists
        if ($member->profile_photo) {
            Storage::disk('public')->delete($member->profile_photo);
        }
        
        $member->delete();

        return response()->json(['success' => true, 'message' => 'Member deleted successfully']);
    }
}