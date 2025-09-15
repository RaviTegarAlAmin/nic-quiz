<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>{{ 'Exam - NIC Quiz' }}</title>
</head>

<body
    class="min-h-screen w-full bg-primary-500 text-gray-900
             antialiased
             flex flex-col
             overflow-x-hidden
             selection:bg-blue-200
             sm:text-base text-sm">
    <div class=" bg-secondary-400 h-32 md:h-48">
        {{ $header ?? '' }}
    </div>

    <div class="flex-1 flex flex-col max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-14">
        {{ $slot }}
    </div>

    @livewireScripts
    <script src="https://unpkg.com/lucide@latest"></script>

</body>

</html>
