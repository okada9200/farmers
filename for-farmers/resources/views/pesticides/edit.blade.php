@extends('layouts.app')

@section('content')
<div class="container">
    <h1>農薬を編集</h1>
    <form action="{{ route('pesticides.update', [$crop->id, $pesticide->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="application_date">散布日</label>
            <input type="date" class="form-control" id="application_date" name="application_date" value="{{ old('application_date', $pesticide->application_date) }}">
        </div>
        <div class="form-group">
            <label for="type">種類</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $pesticide->type) }}">
        </div>
        <div class="form-group">
            <label for="amount">量</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $pesticide->amount) }}">
        </div>
        <div class="form-group">
            <label for="note">メモ</label>
            <textarea class="form-control" id="note" name="note">{{ old('note', $pesticide->note) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
