<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100/50 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-brand-primary" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-600 hover:text-brand-primary active:text-brand-primary font-medium transition-colors duration-200">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('search.index')" :active="request()->routeIs('search.index')" class="text-slate-600 hover:text-brand-primary active:text-brand-primary font-medium transition-colors duration-200">
                        {{ __('Search') }}
                    </x-nav-link>
                    <x-nav-link :href="route('friendships.index')" :active="request()->routeIs('friendships.index')" class="text-slate-600 hover:text-brand-primary active:text-brand-primary font-medium transition-colors duration-200">
                        {{ __('Friendships') }}
                        @if($pendingFriendshipsCount > 0)
                        <span class="ms-1 bg-brand-accent/10 text-brand-accent text-xs font-bold px-1.5 py-0.5 rounded-full ring-1 ring-brand-accent/20">{{ $pendingFriendshipsCount }}</span>
                        @endif
                    </x-nav-link>

                    @if(Auth::user()->user_type === 'job_seeker')
                    <x-nav-link :href="route('job-seeker.profile.edit')" :active="request()->routeIs('job-seeker.profile.edit')" class="text-slate-600 hover:text-brand-primary active:text-brand-primary font-medium transition-colors duration-200">
                        {{ __('My Resume') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-500 bg-transparent hover:text-brand-primary focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-brand-light hover:text-brand-primary">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();" class="hover:bg-brand-light hover:text-brand-primary">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-md border-b border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('search.index')" :active="request()->routeIs('search.index')" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                {{ __('Search') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('friendships.index')" :active="request()->routeIs('friendships.index')" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                {{ __('Friendships') }}
            </x-responsive-nav-link>

            @if(Auth::user()->user_type === 'job_seeker')
            <x-responsive-nav-link :href="route('job-seeker.profile.edit')" :active="request()->routeIs('job-seeker.profile.edit')" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                {{ __('My Resume') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-slate-600 hover:text-brand-primary hover:bg-brand-light/50">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>