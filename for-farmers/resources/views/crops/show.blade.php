@extends('layouts.app')

@section('content')
<h2>作業一覧</h2>

<a href="{{ route('works.create', $crop->id) }}" class="btn btn-primary mb-2">作業を追加</a>

@if($crop->works->count())
    <table class="table">
        <thead>
            <tr>
                <th>作業日</th>
                <th>作業内容</th>
                <th>作業時間</th>
                <th>メモ</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($crop->works as $work)
                <tr>
                    <td>{{ $work->work_date }}</td>
                    <td>{{ $work->work_content }}</td>
                    <td>{{ $work->work_time }} 分</td>
                    <td>{{ $work->note }}</td>
                    <td>
                        <a href="{{ route('works.edit', [$crop->id, $work->id]) }}" class="btn btn-primary">編集</a>
                        <!-- 削除フォーム -->
                        <form action="{{ route('works.destroy', [$crop->id, $work->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<h2>肥料一覧</h2>
<a href="{{ route('fertilizers.create', $crop->id) }}" class="btn btn-primary mb-2">肥料を追加</a>
@if($crop->fertilizers->count())
    <!-- 肥料一覧のテーブル -->
@endif

<h2>農薬一覧</h2>
<a href="{{ route('pesticides.create', $crop->id) }}" class="btn btn-primary mb-2">農薬を追加</a>
@if($crop->pesticides->count())
    <!-- 農薬一覧のテーブル -->
@endif

@endsection

