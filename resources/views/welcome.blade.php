@extends('layouts.guest')

@section('title', 'Call My Doctor - Welcome')

@section('content')
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-12 card-stack bg-black bg-opacity-20 flex flex-col lg:flex-row lg:space-x-4 space-y-4 lg:space-y-0 justify-center items-center">
                <!-- Card: Analyze Medical Report -->
                <a href="{{ route('analyze-medical-report') }}" class="border-b-4 border-yellow-600 bg-blue-900 rounded-xl shadow-lg p-6 text-center text-white z-10 hover:z-40 hover:scale-105 transition-all duration-300 w-full h-56 flex flex-col justify-center items-center">
                    <div class="w-12 h-12 mx-auto mb-4">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold">Analyze Medical Report</h3>
                    <p class="mt-2 text-white text-sm text-center">Upload and analyze your medical reports.</p>
                </a>
                <!-- Card: Buy Prescription -->
                <a href="{{ route('buy-prescription', 1) }}" class="border-b-4 border-yellow-600 bg-blue-900 rounded-xl shadow-lg p-6 text-center text-white z-10 hover:z-40 hover:scale-105 transition-all duration-300 w-full h-64 flex flex-col justify-center items-center">
                    <div class="w-12 h-12 mx-auto mb-4">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold">Buy Prescription</h3>
                    <p class="mt-2 text-white text-sm text-center">Purchase medications online.</p>
                </a>
                <!-- Card: Call a Doctor (First on sm) -->
                <a href="{{ route('call-doctor') }}" class="border-b-4 border-yellow-600 bg-blue-800 rounded-xl shadow-lg p-6 text-center text-white z-30 hover:z-40 hover:scale-105 transition-all duration-300 w-full h-80 flex flex-col justify-center items-center order-first sm:order-none">
                    <div class="w-12 h-12 mx-auto mb-4">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold">Call a Doctor</h3>
                    <p class="mt-2 text-white text-sm text-center">Connect with a doctor instantly.</p>
                    <button id="call-doctor" class="mt-4 bg-green-600 text-white p-6 rounded-full flex items-center hover:bg-green-700 transition duration-600 animate-broadcast">
                        <svg class="w-10 h-10 animate-vibrate" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </button>
                </a>
                <!-- Card: Locate Medical Center -->
                <a href="{{ route('locate-medical-center') }}" class="border-b-4 border-yellow-600 bg-blue-900 rounded-xl shadow-lg p-6 text-center text-white z-10 hover:z-40 hover:scale-105 transition-all duration-300 w-full h-64 flex flex-col justify-center items-center">
                    <div class="w-12 h-12 mx-auto mb-4">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold">Locate Medical Center</h3>
                    <p class="mt-2 text-white text-sm text-center">Find nearby hospitals and clinics.</p>
                </a>
                <!-- Card: Call an Ambulance -->
                <a href="{{ route('call-ambulance') }}" class="border-b-4 border-yellow-600 bg-blue-900 rounded-xl shadow-lg p-6 text-center text-white z-10 hover:z-40 hover:scale-105 transition-all duration-300 w-full h-56 flex flex-col justify-center items-center">
                    <div class="w-12 h-12 mx-auto mb-4">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold">Call an Ambulance</h3>
                    <p class="mt-2 text-white text-sm text-center">Request emergency services quickly.</p>
                </a>
            </div>
        </div>
    </section>
@endsection