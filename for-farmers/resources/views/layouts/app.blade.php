<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>for farmers</title>
    <!-- BootstrapのCSSを読み込み -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesomeの読み込み -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fontsの読み込み -->
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <!-- カスタムCSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            font-size: 1.1em;
            background-color: #f0f4f7;
            color: #333;
        }
        .navbar {
            background-color: #2a9d8f;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .nav-link:hover {
            color: #e9c46a !important;
        }
        .btn {
            font-size: 1em;
            padding: 10px 20px;
            border-radius: 30px;
        }
        h1, h2 {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 20px;
            color: #264653;
        }
        label {
            font-weight: bold;
        }
        .icon {
            margin-right: 5px;
        }
        /* カードデザイン */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #e9c46a;
            color: #fff;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            font-weight: bold;
        }
        .table-custom th,
        .table-custom td {
            border: none;
            padding: 15px;
        }
        .table-custom tr {
            border-bottom: 1px solid #dee2e6;
        }
        .table-custom thead th {
            background-color: #f4a261;
            color: #fff;
        }
        .table-custom tbody tr:hover {
            background-color: #f0f4f7;
        }
        /* ボタンのスタイル */
        .btn-custom {
            background-color: #e76f51;
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #d35400;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">for farmers</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('crops.index') }}"><i class="fas fa-seedling"></i>作物一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('crops.create') }}"><i class="fas fa-plus-circle"></i>作物を追加</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ><i class="fas fa-map-marker-alt"></i>ルート検索</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- 必要なJavaScriptファイルを読み込み -->
    <!-- jQuery（BootstrapのJavaScript機能に必要） -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js（モーダルやツールチップなどに必要） -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- BootstrapのJavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>

