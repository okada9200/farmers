<?php

namespace App\Http\Controllers;

use App\Models\Pesticide;
use App\Models\Crop;
use Illuminate\Http\Request;

class PesticideController extends Controller
{
    public function create(Crop $crop)
    {
        return view('pesticides.create', compact('crop'));
    }

    public function store(Request $request, Crop $crop)
    {
        $request->validate([
            'application_date' => 'required|date',
            'type' => 'required|string|max:255',
            'amount' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $pesticide = new Pesticide($request->all());
        $pesticide->crop_id = $crop->id;
        $pesticide->save();

        return redirect()->route('crops.show', $crop->id)->with('success', '農薬が追加されました。');
    }

    public function edit(Crop $crop, Pesticide $pesticide)
    {
        return view('pesticides.edit', compact('crop', 'pesticide'));
    }

    public function update(Request $request, Crop $crop, Pesticide $pesticide)
    {
        $request->validate([
            'application_date' => 'required|date',
            'type' => 'required|string|max:255',
            'amount' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $pesticide->update($request->all());

        return redirect()->route('crops.show', $crop->id)->with('success', '農薬が更新されました。');

    }

    public function destroy(Crop $crop, Pesticide $pesticide)
    {
        $pesticide->delete();

        return redirect()->route('crops.show', $crop->id)->with('success', '農薬が削除されました。');
    }
}

