@extends('layouts.app')

@section('title', 'Leave Feedback')
@section('navbar-title', 'Leave Feedback')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('schedule.index') }}" class="text-blue-600 hover:text-blue-800">Schedule</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Leave Feedback</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Leave Feedback</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Provide Feedback for Patient</h3>
        <form action="{{ route('appointment.feedback.store', $appointment->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="findings" class="block text-sm font-medium text-gray-700">Findings and Observations</label>
                <textarea id="findings" name="findings" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis/Condition Identified</label>
                <textarea id="diagnosis" name="diagnosis" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="recommendations" class="block text-sm font-medium text-gray-700">Recommendations</label>
                <textarea id="recommendations" name="recommendations" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Submit Feedback</button>
        </form>
    </div>
@endsection