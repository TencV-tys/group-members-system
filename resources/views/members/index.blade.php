@extends('layouts.app')

@section('title', 'Our Members')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Our Members</h1>
        
        @if($members->isEmpty())
            <p class="text-gray-500 text-center py-12 text-xl">No members yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($members as $member)
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition duration-300">
                        <!-- Profile Photo Section -->
                        <div class="h-48 bg-gradient-to-b from-gray-100 to-gray-200 flex items-center justify-center relative">
                            @if($member->profile_photo)
                                <img src="{{ asset('storage/' . $member->profile_photo) }}" 
                                     alt="{{ $member->first_name }} {{ $member->last_name }}"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white absolute -bottom-16 shadow-lg">
                            @else
                                <img src="{{ asset('images/default-image.png') }}" 
                                     alt="Default profile"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white absolute -bottom-16 shadow-lg">
                            @endif
                        </div>
                        
                        <!-- Member Info Section -->
                        <div class="pt-20 p-6 text-center bg-white">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-1">
                                {{ $member->first_name }} {{ $member->last_name }}
                            </h2>
                            
                            <!-- Role Badge -->
                            <span class="inline-block bg-gray-100 text-gray-700 text-sm px-4 py-1 rounded-full mb-4">
                                {{ $member->role }}
                            </span>
                            
                            <!-- Age -->
                            <div class="flex items-center justify-center text-gray-500 mb-4">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $member->age }} years old</span>
                            </div>
                            
                            <!-- Bio Section -->
                            @if($member->bio)
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <p class="text-gray-600 text-sm italic">
                                        "{{ $member->bio }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection