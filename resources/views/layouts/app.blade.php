<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://kit.fontawesome.com/f4c6764ec6.js" crossorigin="anonymous"></script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        {{-- <link rel="preload" as="style" href="https://9085-2a02-8308-a006-d600-b05c-f9f8-d98e-af8d.ngrok-free.app/build/assets/app-0e5066c2.css">
        <link rel="modulepreload" href="https://9085-2a02-8308-a006-d600-b05c-f9f8-d98e-af8d.ngrok-free.app/build/assets/app-4a08c204.js">
        <link rel="stylesheet" href="https://9085-2a02-8308-a006-d600-b05c-f9f8-d98e-af8d.ngrok-free.app/build/assets/app-0e5066c2.css">
        <script type="module" src="https://9085-2a02-8308-a006-d600-b05c-f9f8-d98e-af8d.ngrok-free.app/build/assets/app-4a08c204.js"></script> --}}
        @livewireStyles
    </head>
    
    <body class="font-sans antialiased">
        @livewireScripts
        @livewireCalendarScripts
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
    
</html>
