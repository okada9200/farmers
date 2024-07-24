@extends('layouts.app')

@section('content')
<div class="container">
    <h2>計算されたルート</h2>
    <div id="map" style="height: 500px;"></div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([{{ $route['waypoints'][0]['location'][1] }}, {{ $route['waypoints'][0]['location'][0] }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var coordinates = {!! json_encode($route['trips'][0]['geometry']['coordinates']) !!};
    var latlngs = coordinates.map(function(coord) {
        return [coord[1], coord[0]];
    });

    var polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
    map.fitBounds(polyline.getBounds());
</script>
@endsection
