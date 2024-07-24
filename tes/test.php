<title>PHP</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">PHP</h1>
</header>
<main>
<h2>Practice</h2>
<pre>
<?php
try {
$db = new PDO('mysql:dbname=app;host=localhost;charset=utf8','root','root');
echo "接続OK！";
} catch (PDOException $e) {
echo 'DB接続エラー！: ' . $e->getMessage();
}
?>
</pre>
</main>
</body>