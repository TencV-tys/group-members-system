@extends('layouts.app')

@section('title', 'Home - Group Mark Hudson')

@section('content')
    <div class="min-h-[70vh] flex flex-col items-center justify-center">
        <!-- Big centered text -->
        <h1 class="text-8xl md:text-9xl font-bold text-gray-800 text-center mb-8">
            GROUP MARK HUDSON
        </h1>
        
        <!-- Decorative line -->
        <div class="w-24 h-1 bg-blue-500 mb-6"></div>
        
        <!-- IT ELECTIVE text -->
        <h1 class="text-4xl md:text-5xl font-light text-gray-600 text-center mb-8 tracking-wider">
            IT ELECTIVE
        </h1>
        
        <!-- Another decorative line (optional) -->
        <div class="w-16 h-0.5 bg-gray-300 mb-8"></div>
        
        <!-- Footer text -->
        <p class="text-gray-500 text-lg mt-8">
            Est. 2026
        </p>
    </div>
@endsection