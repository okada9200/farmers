@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>農作物一覧</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>農作物一覧</h1>
        <a href="{{ route('crops.create') }}" class="btn btn-primary">新しい農作物を追加</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>種類</th>
                    <th>品種</th>
                    <th>植え付け日</th>
                    <th>住所</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($crops as $crop)
                    <tr>
                        <td>{{ $crop->id }}</td>
                        <td>{{ $crop->name }}</td>
                        <td>{{ $crop->type }}</td>
                        <td>{{ $crop->variety }}</td>
                        <td>{{ $crop->planting_date }}</td>
                        <td>{{ $crop->address }}</td>
                        <td>
                            <a href="{{ route('crops.show', $crop->id) }}" class="btn btn-info">表示</a>
                            <a href="{{ route('crops.edit', $crop->id) }}" class="btn btn-warning">編集</a>
                            <form action="{{ route('crops.destroy', $crop->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

@endsection

