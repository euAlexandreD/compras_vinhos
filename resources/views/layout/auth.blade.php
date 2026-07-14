<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Catálogo de Vinhos')</title>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-bg font-sans text-ink antialiased">
    @yield('content')
</body>
</html>
