<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('search.index') }}" class="mb-6 flex gap-4">
                        <x-text-input name="search" placeholder="Name or Specialty..." value="{{ request('search') }}" class="w-full" />
                        <select name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">All Types</option>
                            <option value="recruiter" {{ request('type') == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                            <option value="job_seeker" {{ request('type') == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                        </select>
                        <x-primary-button>{{ __('Search') }}</x-primary-button>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($users as $user)
                        <div class="border p-4 rounded-lg shadow">
                            <div class="flex items-center gap-4">
                                @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                @endif
                                <div>
                                    <h3 class="font-bold">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}</p>
                                    @if($user->jobSeeker && $user->jobSeeker->specialty)
                                    <p class="text-xs text-indigo-600">{{ $user->jobSeeker->specialty }}</p>
                                    @endif
                                    @if($user->recruiter && $user->recruiter->company_name)
                                    <p class="text-xs text-indigo-600">{{ $user->recruiter->company_name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('friendships.store') }}">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                    <x-primary-button class="text-xs">{{ __('Add Friend') }}</x-primary-button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <p class="col-span-3 text-center text-gray-500">No users found.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>