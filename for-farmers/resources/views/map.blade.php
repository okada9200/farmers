<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ルート検索（TSP対応）</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet Control Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pVQ0K5BvcQbK2L2QH3C2Hvq0H4oHn5Z9i3u5lxSCjQG0C6VFIJmV0xgBT6k9x+n9cg6y0pTjVJ5lIhhs/9Jr/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }

        /* Container Layout */
        #container {
            display: flex;
            height: 100%;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 350px;
            padding: 30px 20px;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        #sidebar h1 {
            font-size: 1.8em;
            margin-bottom: 25px;
            text-align: center;
            color: #333333;
        }

        /* Form Elements */
        label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #555555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            font-size: 1em;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Destination Group */
        .destination-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .destination-group label {
            flex: 1;
            margin-right: 10px;
        }

        .destination-group input {
            flex: 3;
            padding: 10px 12px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            font-size: 1em;
        }

        .destination-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .remove-destination {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-destination:hover {
            background: #c82333;
        }

        /* Add and Search Buttons */
        .btn {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #add-destination {
            background-color: #17a2b8;
            color: white;
        }

        #add-destination:hover {
            background-color: #138496;
            transform: translateY(-2px);
        }

        #search-route {
            background-color: #28a745;
            color: white;
        }

        #search-route:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        /* Loading Indicator */
        #loading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        #loading img {
            width: 50px;
            margin-bottom: 10px;
        }

        /* Map Styling */
        #map {
            flex: 1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #container {
                flex-direction: column;
            }
            #sidebar {
                width: 100%;
                height: 350px;
                box-shadow: none;
            }
            #map {
                height: calc(100% - 350px);
            }
            .destination-group {
                flex-direction: column;
                align-items: flex-start;
            }
            .destination-group label, .destination-group input, .remove-destination {
                width: 100%;
                margin: 5px 0;
            }
            .remove-destination {
                margin-left: 0;
            }
        }

        /* Additional Enhancements */
        .btn i {
            margin-right: 8px;
        }

        /* Smooth Transitions for Adding/Removing */
        .destination-group {
            transition: all 0.3s ease;
        }

        /* Geocoder Search Box Styling */
        .leaflet-control-geocoder {
            background: white;
            box-shadow: 0 1px 5px rgba(0,0,0,0.4);
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="sidebar">
            <h1>ルート検索（TSP対応）</h1>
            <label for="start"><i class="fas fa-map-marker-alt" style="color:#007bff;"></i> 出発地</label>
            <input type="text" id="start" placeholder="出発地を入力">
    
            <div id="destinations">
                <div class="destination-group">
                    <label>目的地1</label>
                    <input type="text" class="destination" placeholder="目的地を入力">
                    <button class="remove-destination" title="削除"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            <button id="add-destination" class="btn"><i class="fas fa-plus"></i> 目的地を追加</button>
            <button id="search-route" class="btn"><i class="fas fa-route"></i> ルート検索</button>
            <div id="loading">
                <img src="https://i.imgur.com/LLF5iyg.gif" alt="Loading...">
                <p>ルートを検索中...</p>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Control Geocoder JS -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-lrY1W7KjYMGsK1m5cdlBQ46CnK6CU2YQ1LVh+aOJKxT6sV0rGzRG49q6+0edTzMoTQJwG+PQfhuEhkX5G3tkkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([35.6895, 139.6917], 13); // 東京の緯度経度
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Initialize the geocoder control
        L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]).addTo(map);
            map.fitBounds(poly.getBounds());
            poly.bindPopup(e.geocode.name).openPopup();
        })
        .addTo(map);

        var routeLayer;
        var markers = [];

        // Function to add a new destination input group
        function addDestination() {
            var destinations = document.getElementById('destinations');
            var destinationCount = destinations.getElementsByClassName('destination').length + 1;
            var newDestination = document.createElement('div');
            newDestination.className = 'destination-group';
            newDestination.innerHTML = `
                <label>目的地${destinationCount}</label>
                <input type="text" class="destination" placeholder="目的地を入力">
                <button class="remove-destination" title="削除"><i class="fas fa-trash-alt"></i></button>
            `;
            destinations.appendChild(newDestination);

            // Add event listener for remove button
            newDestination.querySelector('.remove-destination').addEventListener('click', function() {
                destinations.removeChild(newDestination);
                updateDestinationLabels();
            });

            // Smoothly scroll to the new destination
            newDestination.scrollIntoView({ behavior: 'smooth' });
        }

        // Function to update destination labels after removal
        function updateDestinationLabels() {
            var destinationGroups = document.getElementsByClassName('destination-group');
            for (var i = 0; i < destinationGroups.length; i++) {
                var label = destinationGroups[i].getElementsByTagName('label')[0];
                label.textContent = '目的地' + (i + 1);
            }
        }

        // Add event listener for "Add Destination" button
        document.getElementById('add-destination').addEventListener('click', addDestination);

        // Add event listener for initial remove button
        document.querySelectorAll('.remove-destination').forEach(function(button) {
            button.addEventListener('click', function() {
                var destinationGroup = this.parentElement;
                destinationGroup.parentElement.removeChild(destinationGroup);
                updateDestinationLabels();
            });
        });

        // Add event listener for "Search Route" button
        document.getElementById('search-route').addEventListener('click', function() {
            var start = document.getElementById('start').value.trim();
            var destinationInputs = document.getElementsByClassName('destination');
            var destinations = [];
            for (var i = 0; i < destinationInputs.length; i++) {
                if (destinationInputs[i].value.trim() !== "") {
                    destinations.push(destinationInputs[i].value.trim());
                }
            }

            // Input validation
            if (start === "") {
                alert('出発地を入力してください。');
                return;
            }

            if (destinations.length === 0) {
                alert('少なくとも1つの目的地を入力してください。');
                return;
            }

            searchRoute(start, destinations);
        });

        // Function to search and display the route
        function searchRoute(start, destinations) {
            showLoading(true);
            clearMap();

            var geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=';
            var waypoints = [];

            // Geocode the start location
            fetch(geocodeUrl + encodeURIComponent(start))
                .then(response => response.json())
                .then(startData => {
                    if (startData.length > 0) {
                        var startLat = parseFloat(startData[0].lat);
                        var startLon = parseFloat(startData[0].lon);
                        waypoints.push({ lat: startLat, lon: startLon });
                        addMarker(startLat, startLon, '出発地');

                        // Geocode all destination locations
                        return Promise.all(destinations.map(destination => fetch(geocodeUrl + encodeURIComponent(destination))));
                    } else {
                        throw new Error('出発地が見つかりません。');
                    }
                })
                .then(destinationResponses => Promise.all(destinationResponses.map(response => response.json())))
                .then(destinationsData => {
                    destinationsData.forEach((data, index) => {
                        if (data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);
                            waypoints.push({ lat: lat, lon: lon });
                            addMarker(lat, lon, '目的地' + (index + 1));
                        }
                    });

                    if (waypoints.length < 2) {
                        throw new Error('有効な目的地が見つかりません。');
                    }

                    // Construct the OSRM Trip API URL for TSP
                    var coordinates = waypoints.map(wp => wp.lon + ',' + wp.lat).join(';');
                    var osrmTripUrl = 'https://router.project-osrm.org/trip/v1/driving/' + coordinates + '?source=first&roundtrip=false&geometries=geojson&overview=full';

                    return fetch(osrmTripUrl);
                })
                .then(response => response.json())
                .then(tripData => {
                    if (tripData.code === 'Ok' && tripData.trips && tripData.trips.length > 0) {
                        var trip = tripData.trips[0];

                        if (routeLayer) {
                            map.removeLayer(routeLayer);
                        }

                        routeLayer = L.geoJSON(trip.geometry, {
                            style: { color: '#007bff', weight: 5, opacity: 0.8 }
                        }).addTo(map);

                        map.fitBounds(routeLayer.getBounds());

                        // Add route markers with sequence
                        trip.waypoints.forEach((wp, index) => {
                            var marker = L.marker([wp.location[1], wp.location[0]], {
                                icon: L.divIcon({
                                    className: 'route-marker',
                                    html: `<div style="background-color:#007bff; color:white; border-radius:50%; width:24px; height:24px; display:flex; align-items:center; justify-content:center;">${index + 1}</div>`,
                                    iconSize: [24, 24],
                                    iconAnchor: [12, 12]
                                })
                            }).addTo(map);
                            marker.bindPopup(`順序: ${index + 1}`);
                            markers.push(marker);
                        });

                    } else {
                        throw new Error('ルートが見つかりません。');
                    }
                })
                .catch(error => {
                    alert(error.message);
                })
                .finally(() => {
                    showLoading(false);
                });
        }

        // Function to add a marker to the map
        function addMarker(lat, lon, popupText) {
            var marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup(popupText);
            markers.push(marker);
        }

        // Function to clear existing map layers and markers
        function clearMap() {
            if (routeLayer) {
                map.removeLayer(routeLayer);
            }
            markers.forEach(marker => {
                map.removeLayer(marker);
            });
            markers = [];
        }

        // Function to show or hide the loading indicator
        function showLoading(show) {
            var loading = document.getElementById('loading');
            if (show) {
                loading.style.display = 'block';
            } else {
                loading.style.display = 'none';
            }
        }
    </script>
</body>
</html>
