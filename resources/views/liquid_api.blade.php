<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  <title>Liquid API DashBoard</title>
</head>
<body>
  <h2>Choose API!</h2>
  <p>{{date("Y/m/d H:i:s")}}</p>
</body>
</html>