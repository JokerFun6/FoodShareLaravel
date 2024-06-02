<!DOCTYPE html>
<html lang="ru" data-theme="light1">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styles')

    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title')</title>

</head>
<body>
@yield('content')
</body>
</html>
