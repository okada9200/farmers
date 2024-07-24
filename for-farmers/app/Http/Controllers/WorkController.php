<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Crop;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function create(Crop $crop)
    {
        return view('works.create', compact('crop'));
    }

    public function store(Request $request, Crop $crop)
    {
        $request->validate([
            'work_date' => 'required|date',
            'work_content' => 'required|string|max:255',
            'work_time' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $crop->works()->create($request->all());

        return redirect()->route('crops.show', $crop->id)->with('success', '作業が追加されました。');
    }

    public function edit(Crop $crop, Work $work)
    {
        return view('works.edit', compact('crop', 'work'));
    }

    public function update(Request $request, Crop $crop, Work $work)
    {
        $request->validate([
            'work_date' => 'required|date',
            'work_content' => 'required|string|max:255',
            'work_time' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $work->update($request->all());
        return redirect()->route('crops.show', $crop->id)->with('success', '作業が更新されました。');
    }

    public function destroy(Crop $crop, Work $work)
    {
        $work->delete();
        return redirect()->route('crops.show', $crop->id)->with('success', '作業が削除されました。');
    }


}

