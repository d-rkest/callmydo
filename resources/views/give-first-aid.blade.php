@extends('layouts.guest')

@section('title', 'Give First Aid')

@section('content')
<section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
    <div class="flex justify-center">
        <div class="w-full max-w-5xl rounded-lg shadow p-6">
            <h1 class="text-2xl bg-white rounded p-3 text-center my-3 font-black">Locate Medical Center</h1>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-2">
                </div>
                <div class="p-6">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4 flex justify-between items-center">
                            <span>{{ session('error') }}</span>
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="this.parentElement.remove()">
                                ✕
                            </button>
                        </div>
                    @endif

                    <!-- Disclaimer -->
                    <div class="mb-4 text-sm text-red-600 bg-red-100 p-2 rounded">
                        <strong>Disclaimer:</strong> First aid guidance provided here is for informational purposes only and should be carried out by qualified medical practitioners. Seek professional medical help immediately in emergencies.
                    </div>

                    <!-- Search Area -->
                    <div class="mb-6">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1 relative">
                                <input 
                                    type="text" 
                                    id="aidSearchInput" 
                                    list="aidList" 
                                    placeholder="Search first aid (e.g., CPR)" 
                                    aria-label="Search first aid"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200"
                                    oninput="validateInput(this)"
                                >
                                <span id="searchError" class="text-red-600 text-sm absolute mt-1 hidden">Please enter a valid topic (min 2 characters).</span>
                                <datalist id="aidList">
                                    @foreach($guides as $guide)
                                        <option value="{{ $guide->name }}"></option>
                                    @endforeach
                                </datalist>
                            </div>

                            <select 
                                id="aidSelect" 
                                aria-label="Select first aid topic" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                onchange="updateSearchInput()"
                            >
                                <option value="">Select a topic</option>
                                @foreach($guides as $guide)
                                    <option value="{{ $guide->name }}">{{ $guide->name }}</option>
                                @endforeach
                            </select>

                            <button 
                                id="searchButton"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition disabled:bg-blue-400 disabled:cursor-not-allowed"
                                onclick="fetchFirstAid()"
                                disabled
                            >
                                Search
                            </button>
                        </div>
                    </div>

                    <!-- Recently Viewed (Optional) -->
                    <div id="recentlyViewed" class="mb-4 text-gray-600 text-sm hidden">
                        <strong>Recently Viewed:</strong> <span id="recentGuide"></span>
                        <button class="ml-2 text-blue-600 hover:text-blue-800" onclick="clearRecent()">Clear</button>
                    </div>

                    <!-- First Aid Details -->
                    <div id="aidDetails" class="text-gray-500">
                        <p>Enter or select a first aid topic to view guidance and video.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let currentFetchController = null;

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), wait);
        };
    }

    function validateInput(input) {
        const value = input.value.trim();
        const errorSpan = document.getElementById('searchError');
        const button = document.getElementById('searchButton');
        if (value.length < 2) {
            errorSpan.classList.remove('hidden');
            button.disabled = true;
        } else {
            errorSpan.classList.add('hidden');
            button.disabled = false;
            autoSelectAid();
        }
    }

    const autoSelectAid = debounce(function() {
        const input = document.getElementById('aidSearchInput');
        const value = input.value.trim().toLowerCase();
        const datalist = document.getElementById('aidList');
        const options = Array.from(datalist.options);
        const matchedOption = options.find(option => 
            option.value.toLowerCase().includes(value)
        );

        // Only suggest, don't overwrite unless selected
        if (matchedOption && value !== matchedOption.value.toLowerCase()) {
            input.setAttribute('data-suggestion', matchedOption.value); // Store suggestion
        } else {
            input.removeAttribute('data-suggestion');
            document.getElementById('aidDetails').innerHTML = '<p class="text-red-600">No matching first aid topic found.</p>';
        }
    }, 300);

    function updateSearchInput() {
        const select = document.getElementById('aidSelect');
        const input = document.getElementById('aidSearchInput');
        const selectedValue = select.value;
        if (selectedValue) {
            input.value = selectedValue;
            validateInput(input); // Re-validate to enable button
            fetchFirstAid(); // Auto-search on selection
        }
    }

    // Trigger fetch when datalist option is selected
    document.getElementById('aidSearchInput').addEventListener('change', function() {
        if (this.value && this.value.length >= 2) {
            fetchFirstAid();
        }
    });

    function fetchFirstAid() {
        const searchTerm = document.getElementById('aidSearchInput').value.trim();
        const details = document.getElementById('aidDetails');
        const recentlyViewed = document.getElementById('recentlyViewed');
        const recentGuide = document.getElementById('recentGuide');

        if (!searchTerm || searchTerm.length < 2) {
            details.innerHTML = '<p class="text-red-600">Please enter a valid first aid topic (min 2 characters).</p>';
            return;
        }

        // Cancel previous request
        if (currentFetchController) {
            currentFetchController.abort();
        }
        currentFetchController = new AbortController();
        const { signal } = currentFetchController;

        details.innerHTML = `
            <div class="flex justify-center py-6">
                <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </div>
        `;

        // Timeout for slow responses
        const timeoutId = setTimeout(() => {
            console.log('Timeout triggered for fetch');
            details.innerHTML = '<p class="text-yellow-600">Loading is taking longer than expected. <button class="ml-2 text-blue-600 hover:text-blue-800" onclick="fetchFirstAid()">Retry</button></p>';
        }, 5000);

        fetch(`{{ route('first-aid.fetch') }}?search=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            signal,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => {
                clearTimeout(timeoutId);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    details.innerHTML = `<p class="text-red-600">${data.error} <button class="ml-2 text-blue-600 hover:text-blue-800" onclick="fetchFirstAid()">Retry</button></p>`;
                } else {
                    const steps = data.steps
                        .split('\n')
                        .map((step, index) => `<li class="mb-2 opacity-0 animate-fade-in" style="animation-delay:${index * 150}ms">${step.trim()}</li>`)
                        .join('');

                    details.innerHTML = `
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">${data.name}</h2>
                                <p class="mb-3 text-gray-600"><strong>Category:</strong> ${formatCategory(data.category)}</p>
                                <hr class="my-4">
                                <h4 class="text-lg font-semibold">Steps to Follow</h4>
                                <ul class="list-none mt-2 space-y-1">${steps}</ul>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Instructional Video</h4>
                                <div class="aspect-w-16 aspect-h-12"> <!-- Increased height with aspect-h-12 -->
                                    <iframe src="${embedURL(data.video_url)}" class="w-full h-full rounded-lg" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    `;

                    // Update recently viewed
                    recentlyViewed.classList.remove('hidden');
                    recentGuide.textContent = data.name;
                    sessionStorage.setItem('recentGuide', data.name);
                }
            })
            .catch(err => {
                clearTimeout(timeoutId);
                console.error('Fetch error:', err);
                if (err.name === 'AbortError') {
                    console.log('Fetch aborted due to new request.');
                } else {
                    details.innerHTML = '<p class="text-red-600">Failed to load first aid details. <button class="ml-2 text-blue-600 hover:text-blue-800" onclick="fetchFirstAid()">Retry</button></p>';
                }
            });
    }

    function embedURL(url) {
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            const videoId = url.split('v=')[1]?.split('&')[0] || url.split('/').pop();
            return `https://www.youtube.com/embed/${videoId}`;
        }
        return url;
    }

    function formatCategory(category) {
        return category
            .replace(/_/g, ' ')
            .replace(/\b\w/g, char => char.toUpperCase());
    }

    // Initial load of recently viewed
    document.addEventListener('DOMContentLoaded', () => {
        const recentGuide = sessionStorage.getItem('recentGuide');
        if (recentGuide) {
            document.getElementById('recentlyViewed').classList.remove('hidden');
            document.getElementById('recentGuide').textContent = recentGuide;
        }
    });

    function clearRecent() {
        sessionStorage.removeItem('recentGuide');
        document.getElementById('recentlyViewed').classList.add('hidden');
        document.getElementById('recentGuide').textContent = '';
    }

    document.getElementById('aidSearchInput').addEventListener('input', autoSelectAid);
    document.getElementById('aidSelect').addEventListener('change', updateSearchInput);
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.4s ease forwards;
    }
</style>
@endsection