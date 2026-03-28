@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome, {{ $member->first_name }}!</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Profile Card -->
        <div class="bg-gray-50 rounded-lg p-6">
            <div class="flex items-center mb-4">
                @if($member->profile_photo)
                    <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-16 h-16 rounded-full object-cover mr-4">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                        <span class="text-gray-600 text-xl font-bold">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                    <p class="text-gray-600">{{ $member->role }}</p>
                </div>
            </div>
            
            <div class="space-y-2">
                <p><span class="font-semibold">Age:</span> {{ $member->age }}</p>
                <p><span class="font-semibold">Bio:</span> {{ $member->bio ?? 'No bio provided' }}</p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
            <a href="{{ route('member.profile.edit') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Edit My Profile
            </a>
        </div>
    </div>
</div>
@endsection