<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title') @yield('title') | @endif
        {{ config('app.name') }}
    </title>

    <livewire:styles/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    {{ $slot }}

    <livewire:scripts/>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
