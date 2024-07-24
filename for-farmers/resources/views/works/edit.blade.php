@extends('layouts.app')

@section('content')
<div class="container">
    <h1>作業を編集</h1>
    <form action="{{ route('works.update', [$crop->id, $work->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="work_date">作業日</label>
            <input type="date" class="form-control" id="work_date" name="work_date" value="{{ old('work_date', $work->work_date) }}">
        </div>
        <div class="form-group">
            <label for="work_content">作業内容</label>
            <input type="text" class="form-control" id="work_content" name="work_content" value="{{ old('work_content', $work->work_content) }}">
        </div>
        <div class="form-group">
            <label for="work_time">作業時間</label>
            <input type="number" class="form-control" id="work_time" name="work_time" value="{{ old('work_time', $work->work_time) }}">
        </div>
        <div class="form-group">
            <label for="note">メモ</label>
            <textarea class="form-control" id="note" name="note">{{ old('note', $work->note) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
