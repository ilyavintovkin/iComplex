<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title-block')</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="menu">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/posts">Посты</a></li>
    </ul>
</div>
<div class="tel">
</div>

 @yield('content')
 @vite(['resources/js/app.js', 'resources/css/app.css'])
</body>
</html>
