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
</head>

<body class="font-sans text-slate-800 antialiased h-full bg-brand-light">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-brand-light relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-brand-primary/5 blur-3xl"></div>
            <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-brand-accent/5 blur-3xl"></div>
        </div>

        <div class="z-10">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-brand-primary" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/80 backdrop-blur-xl shadow-xl ring-1 ring-slate-900/5 sm:rounded-2xl z-10 relative">
            {{ $slot }}
        </div>
    </div>
</body>

</html>