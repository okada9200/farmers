@extends('layouts.app')

@section('content')
<div class="container">
    <h1><i class="fas fa-seedling"></i> 農作物一覧</h1>
    <a href="{{ route('crops.create') }}" class="btn btn-primary btn-lg mb-3"><i class="fas fa-plus-circle"></i> 新しい農作物を追加</a>

    @if (session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if($crops->count())
    <div class="card">
        <div class="card-header">
            作物リスト
        </div>
        <div class="card-body">
            <table class="table table-hover table-custom">
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
                                <a href="{{ route('crops.show', $crop->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> 表示</a>
                                <a href="{{ route('crops.edit', $crop->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> 編集</a>
                                <!-- 削除ボタンに確認ダイアログを追加 -->
                                <form action="{{ route('crops.destroy', $crop->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> 削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <p>登録された農作物がありません。</p>
    @endif
</div>
@endsection
