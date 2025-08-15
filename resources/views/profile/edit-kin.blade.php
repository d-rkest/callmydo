@extends('layouts.app')

@section('title', 'Edit Next of Kin')
@section('navbar-title', 'Edit Next of Kin')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Edit Next of Kin</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <form action="{{ route('profile.update.kin') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="next_of_kin_name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="next_of_kin_name" name="next_of_kin_name" value="{{ old('next_of_kin_name', $userDetail->next_of_kin_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div>
                    <label for="next_of_kin_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="next_of_kin_email" name="next_of_kin_email" value="{{ old('next_of_kin_email', $userDetail->next_of_kin_email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div>
                    <label for="next_of_kin_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="next_of_kin_phone" name="next_of_kin_phone" value="{{ old('next_of_kin_phone', $userDetail->next_of_kin_phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div>
                    <label for="next_of_kin_relationship" class="block text-sm font-medium text-gray-700">Relationship</label>
                    <input type="text" id="next_of_kin_relationship" name="next_of_kin_relationship" value="{{ old('next_of_kin_relationship', $userDetail->next_of_kin_relationship) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
            </div>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Save Changes</button>
            <a href="{{ route('profile') }}" class="ml-2 text-blue-600 hover:text-blue-800">Cancel</a>
        </form>
    </div>
@endsection