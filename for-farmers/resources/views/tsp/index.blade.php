@extends('layouts.app')

@section('content')
<div class="container">
    <h2>分散農地の巡回セールスマン問題</h2>
    <form action="{{ route('tsp.calculate') }}" method="POST">
        @csrf
        <div id="coordinates-input">
            <div class="coordinate">
                <label>緯度:</label>
                <input type="text" name="coordinates[0][lat]" required>
                <label>経度:</label>
                <input type="text" name="coordinates[0][lng]" required>
            </div>
        </div>
        <button type="button" id="add-coordinate">地点を追加</button>
        <button type="submit" class="btn btn-primary">ルートを計算</button>
    </form>
</div>

<script>
document.getElementById('add-coordinate').addEventListener('click', function() {
    var container = document.getElementById('coordinates-input');
    var count = container.getElementsByClassName('coordinate').length;
    var div = document.createElement('div');
    div.className = 'coordinate';
    div.innerHTML = '<label>緯度:</label><input type="text" name="coordinates[' + count + '][lat]" required> <label>経度:</label><input type="text" name="coordinates[' + count + '][lng]" required>';
    container.appendChild(div);
});
</script>
@endsection
