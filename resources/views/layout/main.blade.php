<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NIC-quiz</title>
    @vite('resources/css/app.css')
</head>

<body class=" bg-primary-500">
    <div class="min-h-screen grid grid-rows-[auto_1fr_auto]">

        <!-- Header -->
        <div class="bg-white shadow px-4 py-3">
            <!-- Header content -->
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 md:grid-cols-[240px_1fr] min-h-0">

            <!-- Sidebar (hidden on small screens) -->
            <div class="bg-gray-100 p-4 border-r hidden md:block">
                <!-- Sidebar content -->
            </div>

            <!-- Main Content -->
            <div class="p-4 overflow-y-auto">
                @yield('main-content')
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-white border-t text-center py-3 text-sm text-gray-500">
            <!-- Footer content -->
        </div>

    </div>

</body>

</html>
