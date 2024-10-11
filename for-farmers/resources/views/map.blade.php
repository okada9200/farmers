<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ルート検索（TSP対応）</title>
    <!-- 必要なスタイルシート -->
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet Control Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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

        /* Map Styling */
        #map {
            flex: 1;
        }

        /* Route Order Display */
        #route-order {
            margin-top: 20px;
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
            <input type="text" id="start" placeholder="出発地（例：東京都千代田区1-1-1）を入力">

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
                <p>ルートを検索中...</p>
            </div>

            <!-- Route Order Display -->
            <div id="route-order">
                <h3>目的地巡回ルートの順番</h3>
                <ul id="order-list"></ul>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <!-- 必要なスクリプト -->
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Control Geocoder JS -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // マップの初期化
        var map = L.map('map').setView([35.6895, 139.6917], 13); // 東京の緯度経度
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // その他の変数
        var routeLayer;
        var markers = [];

        // 目的地を追加する関数やイベントリスナーの設定
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

            // 削除ボタンのイベントリスナーを追加
            newDestination.querySelector('.remove-destination').addEventListener('click', function() {
                destinations.removeChild(newDestination);
                updateDestinationLabels();
            });
        }

        // 目的地のラベルを更新する関数
        function updateDestinationLabels() {
            var destinationGroups = document.getElementsByClassName('destination-group');
            for (var i = 0; i < destinationGroups.length; i++) {
                var label = destinationGroups[i].getElementsByTagName('label')[0];
                label.textContent = '目的地' + (i + 1);
            }
        }

        // ボタンのイベントリスナーを追加
        document.getElementById('add-destination').addEventListener('click', addDestination);

        // 初期の削除ボタンのイベントリスナーを追加
        document.querySelectorAll('.remove-destination').forEach(function(button) {
            button.addEventListener('click', function() {
                var destinationGroup = this.parentElement;
                destinationGroup.parentElement.removeChild(destinationGroup);
                updateDestinationLabels();
            });
        });

        // ルート検索ボタンのイベントリスナーを追加
        document.getElementById('search-route').addEventListener('click', function() {
            var start = document.getElementById('start').value.trim();
            var destinationInputs = document.getElementsByClassName('destination');
            var destinations = [];
            for (var i = 0; i < destinationInputs.length; i++) {
                if (destinationInputs[i].value.trim() !== "") {
                    destinations.push(destinationInputs[i].value.trim());
                }
            }

            // 入力のバリデーション
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

        // ルート検索と表示の関数
        function searchRoute(start, destinations) {
            showLoading(true);
            clearMap();

            var geocodeUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=';
            var waypoints = [];
            var inputDestinations = []; // 入力された目的地のリスト

            // 出発地のジオコーディング
            fetch(geocodeUrl + encodeURIComponent(start))
                .then(response => response.json())
                .then(startData => {
                    if (startData.length > 0) {
                        var startLat = parseFloat(startData[0].lat);
                        var startLon = parseFloat(startData[0].lon);
                        waypoints.push({ lat: startLat, lon: startLon });
                        // マーカーは後で追加します

                        // 目的地のジオコーディング
                        return Promise.all(destinations.map(destination => {
                            inputDestinations.push(destination); // 入力順に目的地を保存
                            return fetch(geocodeUrl + encodeURIComponent(destination));
                        }));
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
                            // マーカーは後で追加します
                        } else {
                            console.warn(`目的地${index + 1}が見つかりません。`);
                        }
                    });

                    if (waypoints.length < 2) {
                        throw new Error('有効な目的地が見つかりません。');
                    }

                    // OSRM Trip APIのURLを構築（roundtrip=trueに設定）
                    var coordinates = waypoints.map(wp => wp.lon + ',' + wp.lat).join(';');
                    var osrmTripUrl = 'http://localhost:5050/trip/v1/driving/' + coordinates + '?source=first&roundtrip=true&geometries=geojson&overview=full';

                    return fetch(osrmTripUrl);
                })
                .then(response => response.json())
                .then(tripData => {
                    console.log('OSRM API Response:', tripData);

                    if (tripData.code === 'Ok' && tripData.trips && tripData.trips.length > 0) {
                        var trip = tripData.trips[0];

                        if (routeLayer) {
                            map.removeLayer(routeLayer);
                        }

                        routeLayer = L.geoJSON(trip.geometry, {
                            style: { color: '#007bff', weight: 5, opacity: 0.8 }
                        }).addTo(map);

                        map.fitBounds(routeLayer.getBounds());

                        // ウェイポイントが存在するか確認
                        if (!tripData.waypoints || tripData.waypoints.length === 0) {
                            throw new Error('目的地の情報が見つかりません。');
                        }

                        // ウェイポイントを最適な順序で並べ替え
                        var orderedWaypoints = tripData.waypoints.slice().sort((a, b) => {
                            return a.waypoint_index - b.waypoint_index;
                        });

                        // マーカーを追加
                        orderedWaypoints.forEach((wp, index) => {
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

                        // 目的地の順序を表示
                        displayRouteOrder(orderedWaypoints, inputDestinations);

                    } else {
                        throw new Error('ルートが見つかりません。' + JSON.stringify(tripData));
                    }
                })
                .catch(error => {
                    alert(error.message);
                })
                .finally(() => {
                    showLoading(false);
                });
        }

        // 目的地の順序を表示する関数
        function displayRouteOrder(orderedWaypoints, inputDestinations) {
            var orderList = document.getElementById('order-list');
            orderList.innerHTML = ''; // 既存のリストをクリア

            orderedWaypoints.forEach((wp, index) => {
                var li = document.createElement('li');
                var pointInfo = `地点${index + 1}: `;

                if (index === 0 || index === orderedWaypoints.length - 1) {
                    pointInfo += '出発地';
                } else {
                    // 入力された目的地に対応する名前を表示
                    var destIndex = wp.waypoint_index - 1; // 出発地を除くため-1
                    pointInfo += inputDestinations[destIndex];
                }

                li.textContent = pointInfo;
                orderList.appendChild(li);
            });
        }

        // マーカーを追加する関数
        function addMarker(lat, lon, popupText) {
            var marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup(popupText);
            markers.push(marker);
        }

        // マップ上のレイヤーとマーカーをクリアする関数
        function clearMap() {
            if (routeLayer) {
                map.removeLayer(routeLayer);
            }
            markers.forEach(marker => {
                map.removeLayer(marker);
            });
            markers = [];
        }

        // ローディング表示の切り替え
        function showLoading(show) {
            var loading = document.getElementById('loading');
            if (show) {
                loading.style.display = 'block';
            } else {
                loading.style.display = 'none';
            }
        }

        // 地図クリック時のイベントリスナー
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            // 逆ジオコーディングを行う
            var reverseGeocodeUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&addressdetails=1`;

            fetch(reverseGeocodeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        var address = data.display_name;

                        // 出発地が空の場合は出発地として設定
                        var startInput = document.getElementById('start');
                        if (startInput.value.trim() === "") {
                            startInput.value = address; // 住所を表示
                            addMarker(lat, lon, '出発地'); // マーカーを追加
                        } else {
                            // 目的地として追加
                            var destinationInputs = document.getElementsByClassName('destination');
                            var added = false;
                            for (var i = 0; i < destinationInputs.length; i++) {
                                if (destinationInputs[i].value.trim() === "") {
                                    destinationInputs[i].value = address; // 住所を表示
                                    addMarker(lat, lon, '目的地'); // マーカーを追加
                                    added = true;
                                    break;
                                }
                            }
                            if (!added) {
                                addDestination();
                                var newInput = document.getElementsByClassName('destination');
                                newInput[newInput.length - 1].value = address;
                                addMarker(lat, lon, '目的地');
                            }
                        }
                    } else {
                        alert('位置の住所が見つかりません。');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('エラーが発生しました。');
                });
        });
    </script>
</body>
</html>
