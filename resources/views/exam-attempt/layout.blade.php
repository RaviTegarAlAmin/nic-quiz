<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/js/app.js')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>{{ 'Exam - NIC Quiz' }}</title>
</head>

<body
    class="min-h-screen w-full bg-primary-500 text-gray-900
             antialiased
             flex flex-col
             overflow-x-hidden
             selection:bg-blue-200
             sm:text-base text-sm">
    <div class="bg-secondary-400 h-32 md:h-48">
        @yield('header')
    </div>

    <div class="flex-1 flex flex-col max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-4 sm:mt-6 md:-mt-14">
        @yield('content')
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
</body>

</html>
