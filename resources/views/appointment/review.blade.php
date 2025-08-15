@extends('layouts.app')

@section('title', 'Review Appointment')
@section('navbar-title', 'Review Appointment')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('appointment.index') }}" class="text-blue-600 hover:text-blue-800">Appointments</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Review</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Review Appointment</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Provide Feedback</h3>
        <form action="{{ route('appointment.review.store', $appointment->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <div id="star-rating" class="mt-1 flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="cursor-pointer text-2xl" data-rating="{{ $i }}" onclick="setRating({{ $i }})">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="">
            </div>
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700">Comments</label>
                <textarea id="comment" name="comment" rows="3" placeholder="Share your experience..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit Review</button>
        </form>
    </div>
@endsection

<script>
    function setRating(rating) {
        const stars = document.querySelectorAll('#star-rating span');
        stars.forEach((star, index) => {
            star.style.color = index < rating ? 'gold' : 'gray';
        });
        document.getElementById('rating-input').value = rating;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#star-rating span');
        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const rating = parseInt(star.getAttribute('data-rating'));
                setRating(rating);
            });
            star.addEventListener('mouseout', () => {
                const currentRating = document.getElementById('rating-input').value || 0;
                setRating(currentRating);
            });
        });
    });
</script>