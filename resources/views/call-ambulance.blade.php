@extends('layouts.guest')

@section('title', 'Call an Ambulance')

@section('content')
    <section class="bg-white min-h-screen flex items-center justify-center px-4 hero-background">
        <div class="w-full max-w-md bg-white border-2 border-red-600 rounded-2xl p-8 text-center space-y-6 shadow-lg self-help-card">
            <div>
                <h1 class="text-3xl font-extrabold text-red-600 uppercase tracking-wide">Emergency Call</h1>
                <p class="text-base text-gray-700 mt-2">Connect to the nearest ambulance or emergency service.</p>
            </div>

            <div id="status-area" class="flex items-center justify-center text-gray-700 font-medium text-sm space-x-2">
                <svg class="w-5 h-5 animate-spin text-red-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Detecting your location...</span>
            </div>

            <div id="ambulance-info" class="hidden bg-gray-50 p-5 rounded-xl border border-gray-300 text-left">
                <h2 class="font-semibold text-gray-800 text-lg">🏥 Nearest Emergency Service</h2>
                <p id="service-name" class="text-sm text-gray-600 mt-1">Searching...</p>
                <p id="service-address" class="text-sm text-gray-600 mt-1"></p>
                <p id="service-distance" class="text-sm text-gray-600 mt-1"></p>
            </div>

            <div id="fallback-info" class="hidden bg-yellow-50 p-5 rounded-xl border border-yellow-400 text-left">
                <h2 class="font-semibold text-yellow-700 text-lg">⚠️ Location Unavailable</h2>
                <p class="text-sm text-gray-700 mt-1">Please call an emergency number:</p>
                <ul id="emergency-numbers" class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                    <li>112 (Nigeria/Global)</li>
                    <li>767 (Lagos State Ambulance Service)</li>
                </ul>
            </div>

            <div id="manual-entry" class="hidden bg-gray-50 p-5 rounded-xl border border-gray-300">
                <h2 class="font-semibold text-gray-800 text-lg">📍 Enter Location Manually</h2>
                <form id="manual-location-form" class="mt-3 space-y-3">
                    <input type="text" id="manual-address" class="w-full p-2 border border-gray-300 rounded-lg text-sm" placeholder="Enter your address (e.g., Lagos, Nigeria)" required>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 rounded-lg">Find Emergency Service</button>
                </form>
            </div>

            <a href="tel:112" id="call-button" class="block w-full bg-red-600 hover:bg-red-700 text-white text-lg font-bold py-4 rounded-lg shadow-lg uppercase tracking-wide mt-4">
                Call Emergency Now
            </a>

            <div class="flex justify-between text-sm text-gray-600 font-medium pt-2">
                <button onclick="retryLocation()" class="hover:text-red-600 underline">Retry Location</button>
                <button onclick="toggleManualEntry()" class="hover:text-red-600 underline">Enter Manually</button>
            </div>

            <p class="text-xs text-gray-400 mt-6">
                Remain calm. State your location clearly to the operator.
            </p>
        </div>
    </section>

    <!-- Google Places API -->
    @if(env('GOOGLE_MAPS_API_KEY'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places,geocoding"></script>
    @else
        <script>console.error('Google Maps API key is missing');</script>
    @endif

    <script>
        let userLat = null;
        let userLng = null;

        // Haversine formula for distance calculation
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Detect user location
        function detectLocation() {
            if (!navigator.geolocation) {
                showFallback();
                return;
            }

            document.getElementById('status-area').classList.remove('hidden');
            document.getElementById('ambulance-info').classList.add('hidden');
            document.getElementById('fallback-info').classList.add('hidden');
            document.getElementById('manual-entry').classList.add('hidden');

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;
                    findNearestEmergencyService(userLat, userLng);
                    detectCountry(userLat, userLng);
                },
                (error) => {
                    console.error('Location error:', error);
                    showFallback();
                },
                { timeout: 8000, enableHighAccuracy: true }
            );
        }

        // Find nearest emergency service
        function findNearestEmergencyService(lat, lng) {
            if (typeof google === 'undefined') {
                showFallback();
                return;
            }

            const service = new google.maps.places.PlacesService(document.createElement('div'));
            const request = {
                location: new google.maps.LatLng(lat, lng),
                radius: 10000, // 10km radius
                types: ['hospital', 'health'],
                keyword: 'emergency ambulance'
            };

            service.nearbySearch(request, (results, status) => {
                document.getElementById('status-area').classList.add('hidden');

                if (status !== google.maps.places.PlacesServiceStatus.OK || !results || results.length === 0) {
                    showFallback();
                    return;
                }

                // Get closest service
                const closest = results
                    .map(place => ({
                        name: place.name,
                        address: place.vicinity,
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                        distance: getDistance(lat, lng, place.geometry.location.lat(), place.geometry.location.lng())
                    }))
                    .sort((a, b) => a.distance - b.distance)[0];

                document.getElementById('ambulance-info').classList.remove('hidden');
                document.getElementById('service-name').textContent = closest.name;
                document.getElementById('service-address').textContent = closest.address;
                document.getElementById('service-distance').textContent = `Distance: ${closest.distance.toFixed(1)} km`;

                // Update call button (fallback to 112 if no number available)
                document.getElementById('call-button').href = 'tel:112'; // Placeholder
                document.getElementById('call-button').textContent = 'Call Emergency 112';
            });
        }

        // Detect country for emergency number
        function detectCountry(lat, lng) {
            if (typeof google === 'undefined') return;

            const geocoder = new google.maps.Geocoder();
            const latlng = new google.maps.LatLng(lat, lng);

            geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK && results[0]) {
                    const country = results[0].address_components.find(c => c.types.includes('country'))?.short_name;
                    const numbers = {
                        'NG': ['112', '767'], // Nigeria
                        'US': ['911'],
                        'GB': ['999'],
                        'EU': ['112']
                    };

                    const emergencyNumbers = numbers[country] || numbers['EU'];
                    const list = document.getElementById('emergency-numbers');
                    list.innerHTML = emergencyNumbers.map(num => `<li>${num} ${country === 'NG' && num === '767' ? '(Lagos Ambulance)' : ''}</li>`).join('');

                    // Update call button with primary number
                    document.getElementById('call-button').href = `tel:${emergencyNumbers[0]}`;
                    document.getElementById('call-button').textContent = `Call Emergency ${emergencyNumbers[0]}`;
                }
            });
        }

        // Show fallback
        function showFallback() {
            document.getElementById('status-area').classList.add('hidden');
            document.getElementById('ambulance-info').classList.add('hidden');
            document.getElementById('fallback-info').classList.remove('hidden');
            document.getElementById('call-button').href = 'tel:112';
            document.getElementById('call-button').textContent = 'Call Emergency 112';
        }

        // Toggle manual entry form
        function toggleManualEntry() {
            document.getElementById('manual-entry').classList.toggle('hidden');
            document.getElementById('ambulance-info').classList.add('hidden');
            document.getElementById('fallback-info').classList.add('hidden');
            document.getElementById('status-area').classList.add('hidden');
        }

        // Handle manual location submission
        document.getElementById('manual-location-form')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const address = document.getElementById('manual-address').value;

            if (typeof google === 'undefined') {
                showFallback();
                return;
            }

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address }, (results, status) => {
                if (status === google.maps.GeocoderStatus.OK && results[0]) {
                    userLat = results[0].geometry.location.lat();
                    userLng = results[0].geometry.location.lng();
                    document.getElementById('manual-entry').classList.add('hidden');
                    document.getElementById('status-area').classList.remove('hidden');
                    findNearestEmergencyService(userLat, userLng);
                    detectCountry(userLat, userLng);
                } else {
                    showFallback();
                }
            });
        });

        // Retry location
        function retryLocation() {
            detectLocation();
        }

        // Start location detection
        detectLocation();
    </script>
@endsection