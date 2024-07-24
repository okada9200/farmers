<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ルート検索</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        #map { height: 600px; }
        #inputs { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div id="inputs">
        <label>出発地: <input type="text" id="start" placeholder="出発地を入力"></label>
        <div id="destinations">
            <label>目的地1: <input type="text" class="destination" placeholder="目的地を入力"></label>
        </div>
        <button id="add-destination">目的地を追加</button>
        <button id="search-route">ルート検索</button>
    </div>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var map = L.map('map').setView([35.6895, 139.6917], 13); // 東京の緯度経度
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        document.getElementById('add-destination').addEventListener('click', function() {
            var destinations = document.getElementById('destinations');
            var destinationCount = destinations.getElementsByClassName('destination').length + 1;
            var newDestination = document.createElement('div');
            newDestination.innerHTML = '<label>目的地' + destinationCount + ': <input type="text" class="destination" placeholder="目的地を入力"></label>';
            destinations.appendChild(newDestination);
        });

        document.getElementById('search-route').addEventListener('click', function() {
            var start = document.getElementById('start').value;
            var destinationInputs = document.getElementsByClassName('destination');
            var destinations = [];
            for (var i = 0; i < destinationInputs.length; i++) {
                if (destinationInputs[i].value.trim() !== "") {
                    destinations.push(destinationInputs[i].value.trim());
                }
            }
            searchRoute(start, destinations);
        });

        function searchRoute(start, destinations) {
            var geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=';
            var waypoints = [];

            fetch(geocodeUrl + encodeURIComponent(start))
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        waypoints.push(L.latLng(data[0].lat, data[0].lon));
                        return Promise.all(destinations.map(destination => fetch(geocodeUrl + encodeURIComponent(destination))));
                    } else {
                        throw new Error('出発地が見つかりません');
                    }
                })
                .then(responses => Promise.all(responses.map(response => response.json())))
                .then(dataArray => {
                    dataArray.forEach(data => {
                        if (data.length > 0) {
                            waypoints.push(L.latLng(data[0].lat, data[0].lon));
                        }
                    });
                    L.Routing.control({
                        waypoints: waypoints,
                        router: new L.Routing.OSRMv1({
                            serviceUrl: 'http://localhost:5001/route/v1'
                        }),
                        lineOptions: {
                            styles: [{ color: 'blue', opacity: 0.6, weight: 4 }]
                        }
                    }).addTo(map);
                })
                .catch(error => {
                    alert(error.message);
                });
        }
    </script>
</body>
</html>
