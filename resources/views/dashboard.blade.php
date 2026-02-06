<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($stats as $stat)
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-100 p-6 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full {{ $stat['bg'] }} flex items-center justify-center {{ $stat['color'] }} text-xl">
                        <i class="fa-solid {{ $stat['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</div>
                        <div class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Card -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm rounded-xl border border-slate-100">
                    <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900">Recent Activity</h3>
                    </div>
                    <div class="p-6">
                        @if(empty($recentActivity))
                        <div class="text-slate-500 text-center py-8">
                            No recent activity to show.
                        </div>
                        @else
                        <div class="space-y-6">
                            @foreach($recentActivity as $activity)
                            <div class="flex items-start space-x-4">
                                <div class="mt-1 w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 text-sm">
                                    <i class="fa-solid {{ $activity['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-slate-900">{{ $activity['title'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $activity['subtitle'] }}</p>
                                </div>
                                <div class="text-xs text-slate-400 font-medium">
                                    {{ $activity['date'] }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Side Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-100 h-fit">
                    <div class="p-6 border-b border-slate-50">
                        <h3 class="text-lg font-bold text-slate-900">Quick Actions</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        @if(auth()->user()->isJobSeeker())
                        <a href="{{ route('job-seeker.profile.edit') }}" class="w-full text-left px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 font-medium transition flex items-center justify-between group">
                            <span class="flex items-center">
                                <i class="fa-solid fa-user-pen mr-3 text-slate-400 group-hover:text-brand-primary"></i>
                                Update Profile
                            </span>
                            <span class="text-slate-400 group-hover:text-brand-primary group-hover:translate-x-1 transition-all">→</span>
                        </a>
                        <a href="{{ route('job-seeker.jobs.index') }}" class="w-full text-left px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 font-medium transition flex items-center justify-between group">
                            <span class="flex items-center">
                                <i class="fa-solid fa-magnifying-glass mr-3 text-slate-400 group-hover:text-brand-primary"></i>
                                Search Jobs
                            </span>
                            <span class="text-slate-400 group-hover:text-brand-primary group-hover:translate-x-1 transition-all">→</span>
                        </a>
                        @else
                        <a href="{{ route('job-offers.create') }}" class="w-full text-left px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 font-medium transition flex items-center justify-between group">
                            <span class="flex items-center">
                                <i class="fa-solid fa-plus mr-3 text-slate-400 group-hover:text-brand-primary"></i>
                                Post a Job
                            </span>
                            <span class="text-slate-400 group-hover:text-brand-primary group-hover:translate-x-1 transition-all">→</span>
                        </a>
                        <a href="{{ route('job-offers.index') }}" class="w-full text-left px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 font-medium transition flex items-center justify-between group">
                            <span class="flex items-center">
                                <i class="fa-solid fa-list-check mr-3 text-slate-400 group-hover:text-brand-primary"></i>
                                Manage Offers
                            </span>
                            <span class="text-slate-400 group-hover:text-brand-primary group-hover:translate-x-1 transition-all">→</span>
                        </a>
                        @endif
                        <a href="{{ route('search.index') }}" class="w-full text-left px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 font-medium transition flex items-center justify-between group">
                            <span class="flex items-center">
                                <i class="fa-solid fa-user-group mr-3 text-slate-400 group-hover:text-brand-primary"></i>
                                Discover People
                            </span>
                            <span class="text-slate-400 group-hover:text-brand-primary group-hover:translate-x-1 transition-all">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>