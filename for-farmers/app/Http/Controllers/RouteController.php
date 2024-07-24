<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class RouteController extends Controller
{
    public function calculateRoute(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        
        $osrm_url = "http://localhost:5001/route/v1/driving/{$start};{$end}?overview=full&geometries=geojson";

        $client = new Client();
        $response = $client->get($osrm_url);
        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
    
    public function geocodeAddresses(array $addresses)
    {
        $coordinates = [];
        foreach ($addresses as $address) {
            $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data)) {
                $coordinates[] = $data[0]['lat'] . ',' . $data[0]['lon'];
            } else {
                throw new Exception("住所が見つかりません: " . $address);
            }
        }
        return $coordinates;
    }

    public function computeOptimalRoute(array $coordinates)
    {
        $coordinateString = implode(';', $coordinates);
        $url = "http://localhost:5001/trip/v1/driving/" . $coordinateString . "?source=first&destination=last";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['code'] === 'Ok') {
            return $data['trips'][0]['legs'];
        } else {
            throw new Exception("ルートを計算できません: " . $data['message']);
        }
    }

    public function showOptimalRoute(Request $request)
    {
        $addresses = $request->input('addresses');

        try {
            $coordinates = $this->geocodeAddresses($addresses);
            $route = $this->computeOptimalRoute($coordinates);

            return view('route.optimal', compact('route'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function input()
    {
        return view('route.input');
    }

}

