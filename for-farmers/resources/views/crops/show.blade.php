@extends('layouts.app')

@section('content')
<h2>作業一覧</h2>

<a href="{{ route('works.create', $crop->id) }}" class="btn btn-primary mb-2">作業を追加</a>

@if($crop->works->count())
    <!-- 作業一覧テーブル -->
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
<!-- 肥料一覧テーブル -->
<table class="table">
        <thead>
            <tr>
                <th>施肥日</th>
                <th>種類</th>
                <th>量</th>
                <th>メモ</th>
                <th>操作</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($crop->fertilizers as $fertilizer)
                <tr>
                    <td>{{ $fertilizer->application_date }}</td>
                    <td>{{ $fertilizer->type }}</td>
                    <td>{{ $fertilizer->amount }} kg </td>
                    <td>{{ $fertilizer->note }}</td>
                    <td>
                        <a href="{{ route('fertilizers.edit', [$crop->id, $fertilizer->id]) }}" class="btn btn-primary">編集</a>
                        <form action="{{ route('fertilizers.destroy', [$crop->id, $fertilizer->id]) }}" method="POST" style="display:inline;">
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

<h2>農薬一覧</h2>
<a href="{{ route('pesticides.create', $crop->id) }}" class="btn btn-primary mb-2">農薬を追加</a>
@if($crop->pesticides->count())
    <!-- 農薬一覧のテーブル -->
    <table class="table">
        <thead>
            <tr>
                <th>散布日</th>
                <th>種類</th>
                <th>量</th>
                <th>メモ</th>
                <th>操作</th> <!-- 操作列を追加 -->
            </tr>
        </thead>
        <tbody>
            @foreach($crop->pesticides as $pesticide)
                <tr>
                    <td>{{ $pesticide->application_date }}</td>
                    <td>{{ $pesticide->type }}</td>
                    <td>{{ $pesticide->amount }} L </td>
                    <td>{{ $pesticide->note }}</td>
                    <td>
                        <a href="{{ route('pesticides.edit', [$crop->id, $pesticide->id]) }}" class="btn btn-primary">編集</a>
                        <form action="{{ route('pesticides.destroy', [$crop->id, $pesticide->id]) }}" method="POST" style="display:inline;">
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

@endsection

