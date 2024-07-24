@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>農作物編集</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>農作物編集</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('crops.update', $crop->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">名前:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $crop->name }}" required>
            </div>
            <div class="form-group">
                <label for="type">種類:</label>
                <input type="text" class="form-control" name="type" id="type" value="{{ $crop->type }}" required>
            </div>
            <div class="form-group">
                <label for="variety">品種:</label>
                <input type="text" class="form-control" name="variety" id="variety" value="{{ $crop->variety }}" required>
            </div>
            <div class="form-group">
                <label for="planting_date">植え付け日:</label>
                <input type="date" class="form-control" name="planting_date" id="planting_date" value="{{ $crop->planting_date }}" required>
            </div>
            <div class="form-group">
                <label for="adress">住所:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $crop->address ?? '') }}">
            </div>
            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
</body>
</html>

@endsection
