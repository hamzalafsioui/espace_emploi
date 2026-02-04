<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-brand-light font-sans text-slate-800 h-full selection:bg-brand-primary selection:text-white">
    <div class="relative min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="absolute top-0 w-full z-50 px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <x-application-logo class="h-10 w-auto fill-current text-brand-primary" />
                    <span class="ml-3 text-xl font-bold font-display text-slate-900 tracking-tight">Espace Emploi</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="font-medium text-slate-600 hover:text-brand-primary transition">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="font-medium text-slate-600 hover:text-brand-primary transition">Log in</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-brand-primary text-white font-medium hover:bg-blue-600 transition shadow-lg shadow-blue-500/30">Get Started</a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow flex items-center justify-center relative overflow-hidden pt-20">
            <!-- Background blobs -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
                <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-brand-primary/5 blur-3xl"></div>
                <div class="absolute bottom-[0%] right-[0%] w-[40%] h-[40%] rounded-full bg-brand-accent/5 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-sm font-semibold mb-6">
                        <span class="mr-2">[</span> The #1 Job Platform <span class="ml-2">]</span>
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-bold font-display text-slate-900 leading-tight mb-6">
                        Find your dream <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-accent">career today</span>
                    </h1>
                    <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Connect with top employers and discover opportunities that match your skills and aspirations. Your future starts here.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-brand-primary text-white font-bold text-lg hover:bg-blue-600 transition shadow-xl shadow-brand-primary/20 w-full sm:w-auto">
                            Find a Job
                        </a>
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-white text-slate-800 font-bold text-lg border border-slate-200 hover:border-brand-primary hover:text-brand-primary transition w-full sm:w-auto">
                            Post a Job
                        </a>
                    </div>
                </div>
                
                <div class="hidden lg:block relative">
                    <div class="relative w-full aspect-square max-w-lg mx-auto bg-gradient-to-tr from-brand-light to-white rounded-3xl shadow-2xl border border-slate-100 flex items-center justify-center overflow-hidden">
                        <div class="absolute inset-0 bg-grid-slate-900/[0.04] bg-[bottom_1px_center] [mask-image:linear-gradient(to_bottom,transparent,black)]"></div>
                        <div class="relative text-center p-8">
                            <div class="w-16 h-16 bg-brand-accent rounded-2xl mx-auto mb-4 flex items-center justify-center text-3xl shadow-lg shadow-brand-accent/30">💼</div>
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">New Opportunities</h3>
                            <p class="text-slate-500">Posted daily by top companies</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100 py-12 relative z-10">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Espace Emploi. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-brand-primary transition">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-primary transition">Terms of Service</a>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>