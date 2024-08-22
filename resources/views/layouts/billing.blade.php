<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <title>{{ trans('filament-payments::messages.view.title_pay_page') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @filamentStyles

    <script src="https://unpkg.com/akar-icons-fonts"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-teal-50 antialiased">
    {{-- Content --}}
    @yield('content')

    @livewire('notifications')

    @filamentScripts
</body>

</html>
