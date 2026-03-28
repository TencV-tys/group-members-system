<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    // Remove the __construct method completely

    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user->member) {
            return redirect()->route('home')->with('error', 'No member profile found.');
        }
        
        $member = $user->member;
        return view('member.dashboard', compact('member'));
    }

    public function edit()
    {
        $user = Auth::user();
        $member = $user->member;
        return view('member.profile.edit', compact('member'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;
        
        // Validate - members can only update these fields
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'age' => 'required|integer|min:1|max:150',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            if ($member->profile_photo) {
                Storage::disk('public')->delete($member->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        // Update member
        $member->update($validated);
        
        // Update user name if member name changed
        $user->update([
            'name' => $member->first_name . ' ' . $member->last_name
        ]);

        return redirect()->route('member.dashboard')
            ->with('success', 'Profile updated successfully!');
    }
}