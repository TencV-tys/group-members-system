@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit My Profile</h1>
    
    <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
            <input type="number" name="age" value="{{ old('age', $member->age) }}" required min="1" max="150"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
            <textarea name="bio" rows="4" 
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('bio', $member->bio) }}</textarea>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
            <input type="file" name="profile_photo" accept="image/*"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            @if($member->profile_photo)
                <p class="text-sm text-gray-500 mt-1">Current: <img src="{{ asset('storage/' . $member->profile_photo) }}" class="w-16 h-16 rounded-full mt-1"></p>
            @endif
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('member.dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update Profile</button>
        </div>
    </form>
</div>
@endsection