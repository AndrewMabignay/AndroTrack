<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    {{-- HTTP ASSETS --}}
    @vite('resources/css/app.css')

    {{-- HTTPS ASSETS --}}
    {{-- @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp

    <link rel="stylesheet" href="{{ secure_asset('build/' . $manifest['resources/css/app.css']['file']) }}">
     --}}

    <!-- FONT AWESOME ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <main id="app" data-page="{{ $page }}">
        {{ $slot }}
    </main>

    {{-- HTTP ASSETS --}}
    @vite(['resources/js/app.js'])

    {{-- HTTPS ASSETS --}}
    {{-- <script type="module" src="{{ secure_asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script> --}}
</body>
</html>