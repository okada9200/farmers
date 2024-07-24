<?php

namespace App\Http\Controllers;

use App\Models\Fertilizer;
use App\Models\Crop;
use Illuminate\Http\Request;

class FertilizerController extends Controller
{
    public function create(Crop $crop)
    {
        return view('fertilizers.create', compact('crop'));
    }

    public function store(Request $request, Crop $crop)
    {
        $request->validate([
            'application_date' => 'required|date',
            'type' => 'required|string|max:255',
            'amount' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $fertilizer = new Fertilizer($request->all());
        $fertilizer->crop_id = $crop->id;
        $fertilizer->save();

        return redirect()->route('crops.show', $crop->id)->with('success', '肥料が追加されました。');
    }

    public function edit(Crop $crop, Fertilizer $fertilizer)
    {
        return view('fertilizers.edit', compact('crop', 'fertilizer'));
    }

    public function update(Request $request, Crop $crop, Fertilizer $fertilizer)
    {
        $request->validate([
            'application_date' => 'required|date',
            'type' => 'required|string|max:255',
            'amount' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $fertilizer->update($request->all());

        return redirect()->route('crops.show', $crop->id)->with('success', '肥料が更新されました。');
    }

    public function destroy(Crop $crop, Fertilizer $fertilizer)
    {
        $fertilizer->delete();

        return redirect()->route('crops.show', $crop->id)->with('success', '肥料が削除されました。');
    }

}
