<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    {{-- Titulo --}}
    <title>{{ $title ?? 'Petshop' }}</title>

    {{-- FAV ICON --}}
    <link rel="icon" href="/img/pet-icon.svg" type="image/x-icon">


    {{-- VITE - Tailwind --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Charts JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Fonts poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">


    @livewireStyles
</head>

<body class=" font-poppins overflow-x-hidden">


    {{ $slot }}
    @livewireScripts
</body>

</html>