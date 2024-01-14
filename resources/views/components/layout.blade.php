<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Explore our cinema application demo built in Laravel. Discover the latest movies, top up your account, and purchase tickets online. Browse through the current movie offerings and enjoy the convenience of ticket purchases, all on one platform. Benefit from easy access to movie information and plan your cinema visits effortlessly with our application." />
        <link rel="icon" href="/logo.png" type="image/png">
        <title>{{ $browserTitle ?? "Starlight Cinema" }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-bg-100 text-text-100">
        @if(session('success'))
            <div
                x-init="setTimeout(() => { $el.classList.add('hidden'); }, 5000);"
                class="fixed bottom-4 left-4 z-20 py-1 px-4 bg-green-900 rounded-md border-l-4 border-green-500"
            >
                <span class="text-green-500 font-bold">Success</span>
                <p class="text-green-500">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div
                x-init="setTimeout(() => { $el.classList.add('hidden'); }, 5000);"
                class="fixed bottom-4 left-4 z-20 py-1 px-4 bg-red-900 rounded-md border-l-4 border-red-500"
            >
                <span class="text-red-500 font-bold">Error</span>
                <p class="text-red-500">{{ session('error') }}</p>
            </div>
        @endif
        <x-nav-bar />
        {{ $slot }}
        <footer class="mt-8 py-4 bg-gray-900 text-center text-text-200 tracking-wider">
            <p>&copy; 2023 Mariusz Dłubak. All rights reserved.</p>
        </footer>
    </body>
</html>
