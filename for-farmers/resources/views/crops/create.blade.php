@extends('layouts.app')

@section('content')
<div class="container">
    <h1><i class="fas fa-plus-circle"></i> 農作物追加</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>入力にエラーがあります。</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('crops.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">名前:</label>
                <input type="text" class="form-control" name="name" id="name" required placeholder="作物の名前を入力">
            </div>
            <div class="form-group">
                <label for="type">種類:</label>
                <input type="text" class="form-control" name="type" id="type" required placeholder="作物の種類を入力">
            </div>
            <div class="form-group">
                <label for="variety">品種:</label>
                <input type="text" class="form-control" name="variety" id="variety" required placeholder="作物の品種を入力">
            </div>
            <div class="form-group">
                <label for="planting_date">植え付け日:</label>
                <input type="date" class="form-control" name="planting_date" id="planting_date" required>
            </div>
            <div class="form-group">
                <label for="address">住所:</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="作物の栽培場所を入力">
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-custom"><i class="fas fa-check-circle"></i> 追加</button>
        </form>
    </div>
</div>
@endsection
