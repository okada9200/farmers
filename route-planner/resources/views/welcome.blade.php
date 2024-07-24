
<!DOCTYPE html>
<html>
<head>
    <title>ルートプランナー</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>ルートプランナー</h1>
    <form action="/addresses" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <button type="submit" class="btn btn-primary">住所を追加</button>
    </form>
    <hr>
    <h2>住所一覧</h2>
    <form id="route-form">
        @foreach ($addresses as $address)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $address->address }}" id="address{{ $address->id }}" name="addresses[]">
                <label class="form-check-label" for="address{{ $address->id }}">
                    {{ $address->name }} - {{ $address->address }}
                </label>
            </div>
        @endforeach
        <button type="button" class="btn btn-success" id="get-route">ルートを取得</button>
    </form>
    <hr>
    <h2>ルート結果</h2>
    <pre id="route-result"></pre>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    $('#get-route').click(function() {
        $.ajax({
            url: '/route',
            method: 'POST',
            data: $('#route-form').serialize(),
            success: function(response) {
                $('#route-result').text(JSON.stringify(response, null, 2));
            }
        });
    });
</script>
</body>
</html>

