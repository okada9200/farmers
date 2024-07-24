@extends('layouts.app')

@section('content')
<form action="{{ route('route.showOptimal') }}" method="POST">
    @csrf
    <div id="addressInputs">
        <div>
            <label for="addresses[]">住所 1:</label>
            <input type="text" name="addresses[]" required>
        </div>
    </div>
    <button type="button" onclick="addAddressInput()">住所を追加</button>
    <button type="submit">最適なルートを計算</button>
</form>

<script>
function addAddressInput() {
    var addressInputs = document.getElementById('addressInputs');
    var newInput = document.createElement('div');
    newInput.innerHTML = '<label for="addresses[]">住所:</label><input type="text" name="addresses[]" required>';
    addressInputs.appendChild(newInput);
}
</script>
@endsection
