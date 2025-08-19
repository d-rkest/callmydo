@extends('layouts.guest')

@section('title', 'Buy Prescription')
@section('navbar-title', 'Buy Prescription')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">

        <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Coming Soon</h3>
            <p class="text-gray-600">This feature is under development and will be available soon. Stay tuned!</p>
            <div class="mt-6">
                <a href="{{ route('welcome') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Back to Home</a>
            </div>
        </div>
    </div>
    </section>
@endsection