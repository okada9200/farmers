<?php
namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index()
    {
        $crops = Crop::all();
        return view('crops.index', compact('crops'));
    }

    public function create()
    {
        return view('crops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'variety' => 'required|string|max:255',
            'planting_date' => 'required|date',
            'address' => 'nullable|string|max:255',
        ]);

        Crop::create($request->all());

        return redirect()->route('crops.index')->with('success', '農作物が追加されました。');
    }

    public function show(Crop $crop)
    {
        // $id 変数を使用せず、直接 $crop を渡す
        $crop->load('works');
        return view('crops.show', compact('crop'));
    }

    public function edit(Crop $crop)
    {
        return view('crops.edit', compact('crop'));
    }

    public function update(Request $request, Crop $crop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'variety' => 'required|string|max:255',
            'planting_date' => 'required|date',
            'address' => 'nullable|string|max:255',
        ]);

        $crop->update($request->all());

        return redirect()->route('crops.index')->with('success', '農作物が更新されました。');
    }

    public function destroy(Crop $crop)
    {
        $crop->delete();

        return redirect()->route('crops.index')->with('success', '農作物が削除されました。');
    }
}

