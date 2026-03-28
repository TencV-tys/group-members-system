<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class MemberProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = Auth::user();
        
        if (!$user->member) {
            return redirect()->route('home')->with('error', 'No member profile found.');
        }
        
        $member = $user->member;
        return view('member.profile.edit', compact('member'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;
        
        // Validate - only allow these fields to be updated by members
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'age' => 'required|integer|min:1|max:150',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($member->profile_photo) {
                Storage::disk('public')->delete($member->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $member->update($validated);

        return redirect()->route('member.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $member = $user->member;
        return view('member.dashboard', compact('member'));
    }
}