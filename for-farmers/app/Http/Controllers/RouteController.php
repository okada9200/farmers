<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function index()
    {
        // 最新のルートを取得
        $route = Route::latest()->first();

        if ($route) {
            $start = $route->start;
            $destinations = $route->destinations;
        } else {
            $start = '';
            $destinations = [''];
        }

        return view('map', compact('start', 'destinations'));
    }

    public function save(Request $request)
    {
        // 入力を検証
        $request->validate([
            'start' => 'required|string',
            'destinations' => 'required|array',
            'destinations.*' => 'required|string',
        ]);

        // データベースに保存
        Route::create([
            'start' => $request->input('start'),
            'destinations' => $request->input('destinations'),
        ]);

        return response()->json(['message' => 'ルートが保存されました。']);
    }

    public function clear()
    {
        // データベースのルートを削除
        Route::truncate();

        return response()->json(['message' => '保存されたデータをクリアしました。']);
    }
}
