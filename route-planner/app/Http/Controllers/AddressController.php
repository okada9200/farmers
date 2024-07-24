<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return view('welcome', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        Address::create($request->all());
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
                $coordinates[] = $data[0]['lon'] . ',' . $data[0]['lat'];
            }
        }

        $coordinatesString = implode(';', $coordinates);
        $osrmResponse = Http::get("http://localhost:5050/route/v1/driving/$coordinatesString", [
            'overview' => 'false',
            'geometries' => 'polyline'
        ]);

        return response()->json($osrmResponse->json());
    }
}
