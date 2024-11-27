<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación de OpenMap</title>
    @vite(['resources/css/openmap.css', 'resources/js/openmap.js'])
    @livewireStyles
</head>
<body>
    <header>
        </header>

    <main>
        @yield('content')  </main>

    <footer>
        </footer>
    @livewireScripts
</body>
</html>