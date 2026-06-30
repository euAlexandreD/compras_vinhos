<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catálogo de Vinhos')</title>

    @vite(['resources/css/auth.css'])
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html>
