@extends('layouts.guest')

@section('title', 'Locate Medical Center')

@section('content')
    <!-- Locate Medical Center Section -->
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="flex justify-center">
            <div class="w-full lg:w-11/12 m-5">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-blue-900 text-white px-6 py-2">
                        <h1 class="text-2xl font-bold text-center">Locate Medical Center</h1>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Sidebar Buttons -->
                            <div class="md:col-span-3 space-y-2">
                                <button class="w-full px-4 py-2 text-left bg-blue-100 text-blue-700 rounded hover:bg-blue-200 active:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button active" data-topic="hospital">General Hospital</button>
                                <button class="w-full px-4 py-2 text-left bg-gray-100 text-gray-700 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button" data-topic="specialist_hospital">Specialist Hospital</button>
                                <button class="w-full px-4 py-2 text-left bg-gray-100 text-gray-700 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button" data-topic="pediatric_hospital">Pediatric Hospital</button>
                                <button class="w-full px-4 py-2 text-left bg-gray-100 text-gray-700 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button" data-topic="laboratory">Medical Laboratory</button>
                                <button class="w-full px-4 py-2 text-left bg-gray-100 text-gray-700 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button" data-topic="blood_bank">Blood Bank</button>
                                <button class="w-full px-4 py-2 text-left bg-gray-100 text-gray-700 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 menu-button" data-topic="all">All</button>
                            </div>

                            <!-- Map -->
                            <div class="md:col-span-6">
                                <div id="map" class="w-full h-96 rounded-lg border border-gray-300"></div>
                            </div>

                            <!-- Medical Centers List -->
                            <div class="md:col-span-3">
                                <h4 class="text-lg font-semibold mb-3">Nearby Medical Centers</h4>
                                <ul id="medical-centers-list" class="divide-y divide-gray-200 border rounded-lg">
                                    <li class="p-3 text-gray-500">Locating centers...</li>
                                </ul>
                                <div id="pagination" class="flex justify-center mt-4 space-x-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leaflet JS and Plugin -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.84.2/dist/L.Control.Locate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.84.2/dist/L.Control.Locate.min.js"></script>
    <!-- Google Places API -->
    @if(env('GOOGLE_MAPS_API_KEY'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places,geocoder"></script>
    @else
        <script>console.error('Google Maps API key is missing');</script>
    @endif

    <script>
        // Initialize map
        let map = L.map('map').setView([6.5244, 3.3792], 13); // Default to Lagos, Nigeria
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add locate control
        L.control.locate({
            position: 'topright',
            icon: 'fa fa-location-arrow',
            setView: 'always',
            maxZoom: 16,
            keepCurrentZoomLevel: false,
            locateOptions: { enableHighAccuracy: true }
        }).addTo(map);

        // User location marker and circle
        let userMarker = null;
        let userCircle = null;
        let medicalMarkers = [];
        let currentPage = 1;
        const itemsPerPage = 3;
        let allCenters = [];

        // Custom user icon (red marker)
        const userIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

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

        // Function to get precise area name from coordinates
        function getLocationName(lat, lng) {
            if (typeof google === 'undefined') {
                return 'Your location (area unavailable)';
            }
            const geocoder = new google.maps.Geocoder();
            return new Promise((resolve) => {
                geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        const components = results[0].address_components;
                        let area = components.find(component =>
                            component.types.includes('sublocality') || component.types.includes('locality')
                        );
                        if (!area) {
                            area = components.find(component =>
                                component.types.includes('neighborhood') || component.types.includes('administrative_area_level_2')
                            );
                        }
                        const parentArea = components.find(component =>
                            component.types.includes('administrative_area_level_1')
                        );
                        resolve(area ? `${area.long_name}${parentArea ? ', ' + parentArea.long_name : ''}` : `Your location (approx. ${lat.toFixed(4)}, ${lng.toFixed(4)})`);
                    } else {
                        resolve(`Your location (approx. ${lat.toFixed(4)}, ${lng.toFixed(4)})`);
                    }
                });
            });
        }

        // Render pagination buttons
        function renderPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            if (totalPages <= 1) return;

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.className = `px-3 py-1 rounded ${i === currentPage ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 border border-blue-400 hover:bg-blue-50'} focus:outline-none focus:ring-2 focus:ring-blue-500`;
                button.textContent = i;
                button.addEventListener('click', () => {
                    currentPage = i;
                    updateListAndMarkers();
                });
                pagination.appendChild(button);
            }
        }

        // Update list and markers for current page
        function updateListAndMarkers() {
            const list = document.getElementById('medical-centers-list');
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedCenters = allCenters.slice(start, end);

            // Clear existing markers
            medicalMarkers.forEach(m => map.removeLayer(m));
            medicalMarkers = [];

            // Update map markers
            paginatedCenters.forEach(center => {
                const marker = L.marker([center.lat, center.lng])
                    .addTo(map)
                    .bindPopup(`<b>${center.name}</b><br>${center.address}<br>Distance: ${center.distance.toFixed(1)} km<br>Rating: ${'★'.repeat(Math.round(center.rating))}${'☆'.repeat(5 - Math.round(center.rating))}`);
                medicalMarkers.push(marker);
            });

            // Update list
            list.innerHTML = paginatedCenters.length > 0 ? '' : '<li class="p-3 text-gray-500">No centers found</li>';
            paginatedCenters.forEach((center, index) => {
                const item = document.createElement('li');
                item.className = 'p-3 hover:bg-gray-50 cursor-pointer transition duration-200';
                item.innerHTML = `
                    <h6 class="font-semibold">${center.name}</h6>
                    <p class="text-sm text-gray-600">${center.address}</p>
                    <p class="text-sm text-gray-500">Distance: ${center.distance.toFixed(1)} km</p>
                    <p class="text-sm text-gray-500">Rating: ${'★'.repeat(Math.round(center.rating))}${'☆'.repeat(5 - Math.round(center.rating))}</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${center.lat},${center.lng}" target="_blank" class="mt-2 inline-block px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Get Directions</a>
                `;
                item.addEventListener('click', (e) => {
                    if (!e.target.classList.contains('mt-2')) {
                        medicalMarkers[index].openPopup();
                        map.setView([center.lat, center.lng], 16);
                    }
                });
                list.appendChild(item);
            });

            // Fit bounds
            if (paginatedCenters.length > 0 && userMarker) {
                const bounds = L.latLngBounds([[userMarker.getLatLng().lat, userMarker.getLatLng().lng], ...paginatedCenters.map(c => [c.lat, c.lng])]);
                map.fitBounds(bounds, { padding: [50, 50], maxZoom: 16 });
            }

            // Render pagination
            renderPagination(allCenters.length);
        }

        // Update medical centers on map and list
        function updateMedicalCenters(userLat, userLng, type) {
            const list = document.getElementById('medical-centers-list');
            list.innerHTML = '<li class="p-3 text-gray-500">Loading centers...</li>';

            // Clear existing markers
            medicalMarkers.forEach(m => map.removeLayer(m));
            medicalMarkers = [];

            // Check if Google Maps API is loaded
            if (typeof google === 'undefined') {
                list.innerHTML = '<li class="p-3 text-red-500">Error: Google Maps API not loaded</li>';
                renderPagination(0);
                return;
            }

            // Google Places API search
            const service = new google.maps.places.PlacesService(document.createElement('div'));
            const request = {
                location: new google.maps.LatLng(userLat, userLng),
                radius: 10000, // 10km radius
                types: ['hospital', 'health'],
                keyword: type === 'all' ? 'medical center' :
                        type === 'blood_bank' ? 'blood bank' :
                        type === 'laboratory' ? 'medical laboratory' : type
            };

            service.nearbySearch(request, (results, status) => {
                if (status !== google.maps.places.PlacesServiceStatus.OK || !results) {
                    list.innerHTML = '<li class="p-3 text-gray-500">No centers found</li>';
                    renderPagination(0);
                    return;
                }

                // Process results
                allCenters = results
                    .map(place => ({
                        name: place.name,
                        type: type,
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                        address: place.vicinity,
                        rating: place.rating || 0,
                        time: 'N/A',
                        distance: getDistance(userLat, userLng, place.geometry.location.lat(), place.geometry.location.lng())
                    }))
                    .sort((a, b) => a.distance - b.distance)
                    .slice(0, 15); // Limit to 15 centers to avoid API overuse

                currentPage = 1;
                updateListAndMarkers();
            });
        }

        // Handle location found
        map.on('locationfound', async (e) => {
            const { latlng, accuracy } = e;

            // Update user marker and circle
            if (userMarker) {
                map.removeLayer(userMarker);
                map.removeLayer(userCircle);
            }
            userMarker = L.marker(latlng, { icon: userIcon }).addTo(map);
            userCircle = L.circle(latlng, accuracy / 2).addTo(map);

            // Get precise area name
            const locationName = await getLocationName(latlng.lat, latlng.lng);
            userMarker.bindPopup(`${locationName}`).openPopup();

            // Update medical centers
            updateMedicalCenters(latlng.lat, latlng.lng, document.querySelector('.menu-button.active').dataset.topic);
        });

        // Handle location error
        map.on('locationerror', () => {
            alert('Error: Unable to access your location. Showing default map.');
            updateMedicalCenters(6.5244, 3.3792, 'all');
        });

        // Button click handlers
        document.querySelectorAll('.menu-button').forEach(button => {
            button.addEventListener('click', () => {
                // Toggle active class
                document.querySelectorAll('.menu-button').forEach(btn => btn.classList.remove('active', 'bg-blue-100', 'text-blue-700'));
                button.classList.add('active', 'bg-blue-100', 'text-blue-700');

                const type = button.dataset.topic;
                if (userMarker) {
                    updateMedicalCenters(userMarker.getLatLng().lat, userMarker.getLatLng().lng, type);
                } else {
                    map.locate({ setView: true, maxZoom: 16 });
                }
            });
        });

        // Initial map load
        map.locate({ setView: true, maxZoom: 16 });
    </script>
@endsection