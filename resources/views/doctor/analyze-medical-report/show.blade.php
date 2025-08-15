@extends('layouts.app')

@section('title', 'Give Feedback')
@section('navbar-title', 'Give Feedback')

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
                <a href="{{ route('analyze-medical-report') }}" class="text-blue-600 hover:text-blue-800">Analyze Medical Report</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Give Feedback</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Give Feedback</h2>

    <!-- User Details -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">User Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <h4 class="text-md font-medium text-gray-700">Personal Details</h4>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->userDetail->phone ?? 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ $user->userDetail->gender ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $user->userDetail->address ?? 'N/A' }}</p>
            </div>
            <div>
                <h4 class="text-md font-medium text-gray-700">Medical Information</h4>
                <p><strong>Height:</strong> {{ $user->medicalInformation->height ?? 'N/A' }}</p>
                <p><strong>Blood Group:</strong> {{ $user->medicalInformation->blood_group ?? 'N/A' }}</p>
                <p><strong>Genotype:</strong> {{ $user->medicalInformation->genotype ?? 'N/A' }}</p>
                <p><strong>Allergies:</strong> {{ $user->medicalInformation->known_allergies ?? 'N/A' }}</p>
                <p><strong>Health Issues:</strong> {{ $user->medicalInformation->health_issues ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Feedback Form -->
    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow mt-6">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Provide Feedback</h3>
        <form action="{{ route('doctor.medical-report.feedback.store', $report->id) }}" method="POST" id="feedback-form" class="space-y-4">
            @csrf
            <input type="hidden" name="report_id" value="{{ $report->id }}">
            <div>
                <label for="findings" class="block text-sm font-medium text-gray-700">Findings and Observations</label>
                <textarea id="findings" name="findings" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis/Condition Identified</label>
                <textarea id="diagnosis" name="diagnosis" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="cause" class="block text-sm font-medium text-gray-700">Possible Cause</label>
                <textarea id="cause" name="cause" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Required Medications</label>
                <div id="medications-container" class="space-y-4">
                    <div class="flex space-x-4">
                        <select name="medications[0][drug]" class="mt-1 block w-1/2 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="">Select a Drug</option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication->name }}">{{ $medication->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="medications[0][dosage]" placeholder="e.g., 500mg, twice daily for 7 days" class="mt-1 block w-1/2 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>
                <button type="button" id="add-medication" class="mt-2 bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700">Add Medication</button>
            </div>
            <div>
                <label for="remedy" class="block text-sm font-medium text-gray-700">Local Remedy</label>
                <textarea id="remedy" name="remedy" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="treatment_plan" class="block text-sm font-medium text-gray-700">Treatment Plan</label>
                <textarea id="treatment_plan" name="treatment_plan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes and Comments</label>
                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Submit Feedback</button>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addMedicationBtn = document.getElementById('add-medication');
        const medicationsContainer = document.getElementById('medications-container');
        let medicationCount = 1;

        addMedicationBtn.addEventListener('click', function() {
            medicationCount++;
            const newMedicationDiv = document.createElement('div');
            newMedicationDiv.className = 'flex space-x-4';
            newMedicationDiv.innerHTML = `
                <select name="medications[${medicationCount}][drug]" class="mt-1 block w-1/2 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">Select a Drug</option>
                    @foreach ($medications as $medication)
                        <option value="{{ $medication->name }}">{{ $medication->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="medications[${medicationCount}][dosage]" placeholder="e.g., 500mg, twice daily for 7 days" class="mt-1 block w-1/2 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            `;
            medicationsContainer.appendChild(newMedicationDiv);
        });
    });
</script>