@extends('layouts.app')

@section('title', 'Edit Medical Information')
@section('navbar-title', 'Edit Medical Information')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Edit Medical Information</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <form action="{{ route('profile.update.medical') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                    <input type="text" id="height" name="height" value="{{ old('height', $medicalInfo->height) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label for="blood_group" class="block text-sm font-medium text-gray-700">Blood Group</label>
                    <input type="text" id="blood_group" name="blood_group" value="{{ old('blood_group', $medicalInfo->blood_group) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label for="genotype" class="block text-sm font-medium text-gray-700">Genotype</label>
                    <input type="text" id="genotype" name="genotype" value="{{ old('genotype', $medicalInfo->genotype) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label for="known_allergies" class="block text-sm font-medium text-gray-700">Known Allergies</label>
                    <input type="text" id="known_allergies" name="known_allergies" value="{{ old('known_allergies', $medicalInfo->known_allergies) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label for="health_issues" class="block text-sm font-medium text-gray-700">Health Issues</label>
                    <input type="text" id="health_issues" name="health_issues" value="{{ old('health_issues', $medicalInfo->health_issues) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Save Changes</button>
            <a href="{{ route('profile') }}" class="ml-2 text-blue-600 hover:text-blue-800">Cancel</a>
        </form>
    </div>
@endsection