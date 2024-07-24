@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>肥料追加</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>肥料追加</h1>
        <form method="POST" action="{{ route('fertilizers.store', $crop->id) }}">
            @csrf
            <div class="form-group">
                <label for="application_date">施肥日</label>
                <input type="date" class="form-control" id="application_date" name="application_date" required>
            </div>
            <div class="form-group">
                <label for="type">種類</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="form-group">
                <label for="amount">量</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="note">メモ</label>
                <textarea class="form-control" id="note" name="note"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">追加</button>
            <a href="{{ route('crops.show', $crop->id) }}" class="btn btn-secondary">戻る</a>
        </form>
    </div>
</body>
</html>

@endsection
