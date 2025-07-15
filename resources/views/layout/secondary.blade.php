<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NIC-quiz</title>
    @vite('resources/css/app.css')
</head>

<body class=" bg-primary-300 text-slate-800 mx-auto">
    <div class="min-h-screen grid grid-rows-[1fr_auto]">

        <!-- Main Content -->
        <div class="p-4 overflow-y-auto mt-10">
            @yield('main-content')
        </div>

        <!-- Footer -->
        <div class=" bg-secondary-400 border-t text-center py-4 text-sm text-white">
            MTs Nic 2025
        </div>

    </div>

</body>

</html>
