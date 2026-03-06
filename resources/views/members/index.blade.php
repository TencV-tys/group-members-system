@extends('layouts.app')

@section('title', 'Our Members')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Our Members</h1>
        
        @if($members->isEmpty())
            <p class="text-gray-500 text-center py-12 text-xl">No members yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($members as $member)
                    <div class="border rounded-lg p-6 hover:shadow-xl transition duration-300">
                        <h2 class="text-2xl font-semibold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                        <p class="text-blue-600 font-medium mb-3">{{ $member->role }}</p>
                        <p class="text-gray-600 mb-3">{{ $member->bio }}</p>
                        <p class="text-sm text-gray-500">Age: {{ $member->age }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection