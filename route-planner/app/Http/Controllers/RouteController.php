<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    public function index()
    {
        return view('route');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        // リクエストから _token を取り除きます
        $data = $request->except('_token');
        Address::create($data);

        return redirect()->back();
    }

    public function getRoute(Request $request)
    {
        $addresses = $request->addresses;

        $coordinates = [];
        foreach ($addresses as $address) {
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json'
            ]);

            $data = $response->json();
            if (count($data) > 0) {
                $coordinates[] = $data[0]['lat'] . ',' . $data[0]['lon'];
            }
        }

        $url = 'http://127.0.0.1:5050/route/v1/driving/' . implode(';', $coordinates) . '?overview=false';
        $routeResponse = Http::get($url);
        $routeData = $routeResponse->json();

        return view('route', compact('routeData'));
    }
}

