<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TSPController extends Controller
{
    public function index()
    {
        return view('tsp.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'coordinates' => 'required|array|min:2',
            'coordinates.*.lat' => 'required|numeric',
            'coordinates.*.lng' => 'required|numeric',
        ]);

        $coordinates = $request->input('coordinates');
        $osrmUrl = $this->generateOSRMUrl($coordinates);
        $response = file_get_contents($osrmUrl);
        $route = json_decode($response, true);

        return view('tsp.result', ['route' => $route]);
    }

    private function generateOSRMUrl($coordinates)
    {
        $baseUrl = 'http://router.project-osrm.org/trip/v1/driving/';
        $coords = array_map(function($coord) {
            return $coord['lng'] . ',' . $coord['lat'];
        }, $coordinates);
        $coordsString = implode(';', $coords);
        return $baseUrl . $coordsString . '?source=first&destination=last&roundtrip=false&overview=full';
    }
}
