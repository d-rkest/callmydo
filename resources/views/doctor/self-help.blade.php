@extends('layouts.app')

@section('title', 'Self Help')
@section('navbar-title', 'Self Help')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Doctor Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Self Help</span>
            </li>
        </ol>
    </nav>
    <!-- Self Help Section -->

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Self Help</h2>

    <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Self Help</h3>
        
        <!-- Search Area -->
        <div class="self-help-search mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        id="illnessSearchInput" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        list="illnessList" 
                        placeholder="Search illness (e.g., Malaria)" 
                        aria-label="Search illness"
                    >
                    <datalist id="illnessList">
                        @foreach($illnesses as $illness)
                            <option value="{{ $illness->name }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <select 
                    id="illnessSelect" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    aria-label="Select illness"
                >
                    <option value="">Select an illness</option>
                    @foreach($illnesses as $illness)
                        <option value="{{ $illness->id }}">{{ $illness->name }}</option>
                    @endforeach
                </select>
                <button 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                    onclick="fetchIllness()"
                >
                    Search
                </button>
            </div>
        </div>

        <!-- Illness Details -->
        <div id="illnessDetails" class="self-help-details text-gray-500">
            <p>Select or search an illness to view details.</p>
        </div>
    </div>

    <script>
        // Debounce function to limit fetch calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Auto-select illness from search input
        const autoSelectIllness = debounce(function() {
            const input = document.getElementById('illnessSearchInput').value.trim().toLowerCase();
            const select = document.getElementById('illnessSelect');
            const options = Array.from(select.options);

            console.log('Search input:', input); // Debug

            const matchedOption = options.find(option => 
                option.textContent.toLowerCase().includes(input) && option.value
            );

            if (matchedOption) {
                select.value = matchedOption.value;
                console.log('Matched option:', matchedOption.textContent); // Debug
                fetchIllness();
            } else {
                select.value = '';
                document.getElementById('illnessDetails').innerHTML = '<p class="text-red-600">No matching illness found.</p>';
            }
        }, 300);

        // Fetch illness details
        function fetchIllness() {
            const id = document.getElementById('illnessSelect').value;
            const details = document.getElementById('illnessDetails');

            if (!id) {
                details.innerHTML = '<p class="text-red-600">Please select an illness.</p>';
                return;
            }

            details.innerHTML = '<div class="text-center"><div class="inline-block h-6 w-6 animate-spin rounded-full border-4 border-blue-500 border-t-transparent" role="status"><span class="sr-only">Loading...</span></div></div>';

            fetch(`{{ route('self-help.fetch') }}?illness_id=${encodeURIComponent(id)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    console.log('Fetch response status:', response.status); // Debug
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetch data:', data); // Debug
                    if (data.error) {
                        details.innerHTML = `<p class="text-red-600">${data.error}</p>`;
                    } else {
                        details.innerHTML = `
                            <h2 class="text-2xl font-bold mb-3">${data.name}</h2>
                            <p class="mb-3"><strong class="font-semibold">Category:</strong> ${formatCategory(data.category)}</p>
                            <hr class="my-4">
                            <div class="leading-relaxed">
                                <h4 class="text-lg font-semibold">Symptoms</h4>
                                <p class="mb-4">${data.symptoms.replace(/\n/g, '<br>')}</p>
                                ${data.local_remedy ? `<h4 class="text-lg font-semibold">Local Remedy</h4><p class="mb-4">${data.local_remedy.replace(/\n/g, '<br>')}</p>` : ''}
                                ${data.otc_medications ? `<h4 class="text-lg font-semibold">OTC Medications</h4><p class="mb-4">${data.otc_medications.replace(/\n/g, '<br>')}</p>` : ''}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    details.innerHTML = '<p class="text-red-600">Failed to load illness details. Please try again.</p>';
                });
        }

        // Format category name
        function formatCategory(category) {
            return category
                .replace(/_/g, ' ')
                .replace(/\b\w/g, char => char.toUpperCase());
        }

        // Event listeners
        document.getElementById('illnessSearchInput').addEventListener('input', autoSelectIllness);
        document.getElementById('illnessSelect').addEventListener('change', fetchIllness);
    </script>
@endsection