@extends('layouts.app')

@section('content')
<div id="map" style="height: 600px;"></div>

<script>
    var map = L.map('map').setView([35.6895, 139.6917], 10); // 東京を中心に設定

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors
    }).addTo(map);

    var route = @json($route);

    var latlngs = route.map(function(leg) {
        return [leg.steps[0].maneuver.location[1], leg.steps[0].maneuver.location[0]];
    });

    L.polyline(latlngs, {color: 'blue'}).addTo(map);
</script>
@endsection
