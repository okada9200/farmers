@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>作業追加</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>作業追加 - {{ $crop->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('works.store', $crop->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="work_date">作業日:</label>
                <input type="date" class="form-control" name="work_date" id="work_date" required>
            </div>
            <div class="form-group">
                <label for="work_content">作業内容:</label>
                <input type="text" class="form-control" name="work_content" id="work_content" required>
            </div>
            <div class="form-group">
                <label for="work_time">作業時間 (分):</label>
                <input type="number" class="form-control" name="work_time" id="work_time" required>
            </div>
            <div class="form-group">
                <label for="note">メモ:</label>
                <textarea class="form-control" name="note" id="note"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">追加</button>
        </form>
    </div>
</body>
</html>

@endsection
