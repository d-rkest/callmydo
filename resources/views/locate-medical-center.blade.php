@extends('layouts.guest')

@section('title', 'Locate Medical Center')

@section('content')
<section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
    <div class="flex justify-center">
        <div class="w-full lg:w-11/12">
            <h1 class="text-2xl bg-white rounded p-3 text-center m-3 font-black">Locate Medical Center</h1>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-2">
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        
                        <!-- Sidebar Buttons and Search -->
                        <div class="md:col-span-3 space-y-2">
                            <div>
                                <label for="location-search" class="block text-sm font-medium text-gray-700">Enter Location</label>
                                <input type="text" id="location-search" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Lagos, Nigeria">
                            </div>
                            <button class="menu-button active w-full px-4 py-2 text-left bg-blue-100 text-blue-700 rounded hover:bg-blue-200" data-topic="hospital">General Hospital</button>
                            <button class="menu-button w-full px-4 py-2 text-left bg-gray-100 hover:bg-blue-200 rounded" data-topic="specialist_hospital">Specialist Hospital</button>
                            <button class="menu-button w-full px-4 py-2 text-left bg-gray-100 hover:bg-blue-200 rounded" data-topic="pediatric_hospital">Pediatric Hospital</button>
                            <button class="menu-button w-full px-4 py-2 text-left bg-gray-100 hover:bg-blue-200 rounded" data-topic="laboratory">Medical Laboratory</button>
                            <button class="menu-button w-full px-4 py-2 text-left bg-gray-100 hover:bg-blue-200 rounded" data-topic="blood_bank">Blood Bank</button>
                            <button class="menu-button w-full px-4 py-2 text-left bg-gray-100 hover:bg-blue-200 rounded" data-topic="all">All</button>
                        </div>

                        <!-- Map -->
                        <div class="md:col-span-6">
                            <div id="map" class="w-full h-96 rounded border"></div>
                        </div>

                        <!-- Medical Centers List -->
                        <div class="md:col-span-3">
                            <h4 class="text-lg font-semibold mb-3">Nearby Medical Centers</h4>
                            <ul id="medical-centers-list" class="divide-y divide-gray-200 border rounded overflow-hidden">
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

<!-- Leaflet & Plugins -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.84.2/dist/L.Control.Locate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.84.2/dist/L.Control.Locate.min.js"></script>

<!-- Nominatim for Geocoding (optional fallback) -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    let map = L.map('map').setView([6.5244, 3.3792], 13); // Default to Lagos, Nigeria
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);

    L.control.locate({
        position: 'topright',
        icon: 'fa fa-location-arrow',
        setView: 'always',
        maxZoom: 16,
        locateOptions: { enableHighAccuracy: true }
    }).addTo(map);

    let userMarker = null;
    let userCircle = null;
    let medicalMarkers = [];
    let currentPage = 1;
    const itemsPerPage = 3;
    let allCenters = [];

    const userIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        shadowSize: [41, 41]
    });

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) ** 2 + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon/2) ** 2;
        return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
    }

    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.className = `px-3 py-1 rounded border transition ${i === currentPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-blue-600 border-blue-400 hover:bg-blue-50'}`;
            button.textContent = i;
            button.addEventListener('click', () => {
                currentPage = i;
                updateListAndMarkers();
            });
            pagination.appendChild(button);
        }
    }

    function updateListAndMarkers() {
        const list = document.getElementById('medical-centers-list');
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedCenters = allCenters.slice(start, end);

        medicalMarkers.forEach(m => map.removeLayer(m));
        medicalMarkers = [];

        list.innerHTML = '';

        if (paginatedCenters.length === 0) {
            list.innerHTML = '<li class="p-3 text-gray-500">No centers found</li>';
        } else {
            paginatedCenters.forEach(center => {
                const marker = L.marker([center.lat, center.lng])
                    .addTo(map)
                    .bindPopup(`<b>${center.name}</b><br>${center.address || 'No address available'}<br>Distance: ${center.distance.toFixed(1)} km`);
                medicalMarkers.push(marker);

                const item = document.createElement('li');
                item.className = 'p-3 cursor-pointer hover:bg-gray-50 transition ease-in-out duration-200 opacity-0 translate-y-2';
                item.innerHTML = `
                    <h6 class="font-semibold">${center.name}</h6>
                    <p class="text-sm text-gray-600">${center.address || 'No address available'}</p>
                    <p class="text-sm text-gray-500">Distance: ${center.distance.toFixed(1)} km</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${center.lat},${center.lng}" target="_blank" class="mt-2 inline-block px-3 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700">Get Directions</a>
                `;
                item.addEventListener('click', (e) => {
                    if (!e.target.classList.contains('mt-2')) {
                        marker.openPopup();
                        map.setView([center.lat, center.lng], 16);
                    }
                });
                list.appendChild(item);

                requestAnimationFrame(() => {
                    item.classList.remove('opacity-0', 'translate-y-2');
                    item.classList.add('opacity-100', 'translate-y-0');
                });
            });
        }

        renderPagination(allCenters.length);
    }

    function updateMedicalCenters(lat, lng, type) {
        const list = document.getElementById('medical-centers-list');
        list.innerHTML = '<li class="p-3 text-gray-500">Loading centers...</li>';

        const overpassUrl = 'https://overpass-api.de/api/interpreter';
        let query = `
            [out:json];
            (
        `;

        if (type === 'all') {
            query += `
                node["amenity"~"hospital|clinic|doctors|pharmacy|laboratory|blood_bank"](around:20000,${lat},${lng});
                way["amenity"~"hospital|clinic|doctors|pharmacy|laboratory|blood_bank"](around:20000,${lat},${lng});
                relation["amenity"~"hospital|clinic|doctors|pharmacy|laboratory|blood_bank"](around:20000,${lat},${lng});
            `;
        } else if (type === 'specialist_hospital' || type === 'pediatric_hospital') {
            query += `
                node["amenity"="hospital"]["healthcare:speciality"~"${type === 'specialist_hospital' ? '.*' : 'paediatric'}"](around:20000,${lat},${lng});
                way["amenity"="hospital"]["healthcare:speciality"~"${type === 'specialist_hospital' ? '.*' : 'paediatric'}"](around:20000,${lat},${lng});
                relation["amenity"="hospital"]["healthcare:speciality"~"${type === 'specialist_hospital' ? '.*' : 'paediatric'}"](around:20000,${lat},${lng});
            `;
        } else {
            query += `
                node["amenity"="${type}"](around:20000,${lat},${lng});
                way["amenity"="${type}"](around:20000,${lat},${lng});
                relation["amenity"="${type}"](around:20000,${lat},${lng});
            `;
        }

        query += `
            );
            out body;
            >;
            out skel qt;
        `;

        fetch(overpassUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'data=' + encodeURIComponent(query)
        })
        .then(response => response.json())
        .then(data => {
            if (!data.elements || data.elements.length === 0) {
                console.log('No centers found via Overpass API. Using fallback data.');
                useFallbackData(lat, lng, type);
                return;
            }

            allCenters = data.elements.map(element => {
                const lat = element.lat || (element.center ? element.center.lat : element.bounds ? (element.bounds.minlat + element.bounds.maxlat) / 2 : lat);
                const lon = element.lon || (element.center ? element.center.lon : element.bounds ? (element.bounds.minlon + element.bounds.maxlon) / 2 : lng);
                return {
                    name: element.tags.name || 'Unnamed Medical Center',
                    type: type,
                    lat: parseFloat(lat),
                    lng: parseFloat(lon),
                    address: element.tags.addr || 'No address available',
                    rating: 0,
                    distance: getDistance(lat, lng, parseFloat(lat), parseFloat(lon))
                };
            })
            .sort((a, b) => a.distance - b.distance)
            .slice(0, 15);

            currentPage = 1;
            updateListAndMarkers();
        })
        .catch(error => {
            console.error('Overpass API error:', error);
            list.innerHTML = '<li class="p-3 text-red-500">Error loading centers. Using fallback data.</li>';
            useFallbackData(lat, lng, type);
        });
    }

    function useFallbackData(lat, lng, type) {
        const fallbackData = [
            { name: 'Lagos University Teaching Hospital', type: 'hospital', lat: 6.5156, lng: 3.3902, address: 'Idi-Araba, Lagos', rating: 4, distance: getDistance(lat, lng, 6.5156, 3.3902) },
            { name: 'St. Nicholas Hospital', type: 'specialist_hospital', lat: 6.4483, lng: 3.4078, address: 'Victoria Island, Lagos', rating: 4, distance: getDistance(lat, lng, 6.4483, 3.4078) },
            { name: 'PathCare Laboratory', type: 'laboratory', lat: 6.5244, lng: 3.3792, address: 'Ikeja, Lagos', rating: 3, distance: getDistance(lat, lng, 6.5244, 3.3792) },
            { name: 'Lagos State Blood Bank', type: 'blood_bank', lat: 6.5000, lng: 3.4000, address: 'Yaba, Lagos', rating: 3, distance: getDistance(lat, lng, 6.5000, 3.4000) }
        ];

        allCenters = fallbackData
            .filter(center => type === 'all' || center.type === type || (type === 'hospital' && center.type === 'specialist_hospital'))
            .sort((a, b) => a.distance - b.distance)
            .slice(0, 15);

        currentPage = 1;
        updateListAndMarkers();
    }

    // Manual location search using Nominatim
    document.getElementById('location-search').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            axios.get('https://nominatim.openstreetmap.org/search', {
                params: {
                    q: e.target.value,
                    format: 'json',
                    limit: 1
                }
            })
            .then(response => {
                if (response.data && response.data.length > 0) {
                    const { lat, lon } = response.data[0];
                    map.setView([parseFloat(lat), parseFloat(lon)], 13);

                    if (userMarker) {
                        map.removeLayer(userMarker);
                        map.removeLayer(userCircle);
                    }
                    userMarker = L.marker([parseFloat(lat), parseFloat(lon)], { icon: userIcon }).addTo(map).bindPopup('Searched location').openPopup();
                    userCircle = L.circle([parseFloat(lat), parseFloat(lon)], 500).addTo(map);

                    updateMedicalCenters(parseFloat(lat), parseFloat(lon), document.querySelector('.menu-button.active').dataset.topic);
                } else {
                    alert('Location not found. Please try again.');
                }
            })
            .catch(error => {
                console.error('Nominatim error:', error);
                alert('Error geocoding location. Using default location.');
                updateMedicalCenters(6.5244, 3.3792, document.querySelector('.menu-button.active').dataset.topic);
            });
        }
    });

    map.on('locationfound', (e) => {
        const { latlng, accuracy } = e;
        let locationName = 'Current Location';

        // Reverse geocode to get place name
        axios.get('https://nominatim.openstreetmap.org/reverse', {
            params: {
                lat: latlng.lat,
                lon: latlng.lng,
                format: 'json',
                addressdetails: 1
            }
        })
        .then(response => {
            if (response.data && response.data.address) {
                const address = response.data.address;
                locationName = address.city || address.town || address.village || address.suburb || address.road || 'Unknown Location';
            }
            if (userMarker) {
                map.removeLayer(userMarker);
                map.removeLayer(userCircle);
            }
            userMarker = L.marker(latlng, { icon: userIcon }).addTo(map).bindPopup(locationName).openPopup();
            userCircle = L.circle(latlng, accuracy / 2).addTo(map);

            updateMedicalCenters(latlng.lat, latlng.lng, document.querySelector('.menu-button.active').dataset.topic);
        })
        .catch(error => {
            console.error('Reverse geocoding error:', error);
            if (userMarker) {
                map.removeLayer(userMarker);
                map.removeLayer(userCircle);
            }
            userMarker = L.marker(latlng, { icon: userIcon }).addTo(map).bindPopup('Current Location').openPopup();
            userCircle = L.circle(latlng, accuracy / 2).addTo(map);

            updateMedicalCenters(latlng.lat, latlng.lng, document.querySelector('.menu-button.active').dataset.topic);
        });
    });

    map.on('locationerror', (e) => {
        console.error('Location error:', e.message);
        alert('Unable to access location. Using default map and fallback data.');
        updateMedicalCenters(6.5244, 3.3792, document.querySelector('.menu-button.active').dataset.topic);
    });

    document.querySelectorAll('.menu-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.menu-button').forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700', 'active'));
            button.classList.add('bg-blue-100', 'text-blue-700', 'active');

            const type = button.dataset.topic;
            if (userMarker) {
                updateMedicalCenters(userMarker.getLatLng().lat, userMarker.getLatLng().lng, type);
            } else {
                map.locate({ setView: true, maxZoom: 16 });
            }
        });
    });

    map.locate({ setView: true, maxZoom: 16 });
</script>
@endsection