<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Friendships') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Pending Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Pending Requests') }}
                        @if($pendingRequests->count() > 0)
                        <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingRequests->count() }}</span>
                        @endif
                    </h3>

                    <div class="space-y-4">
                        @forelse($pendingRequests as $request)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center gap-4">
                                @if($request->sender->photo)
                                <img src="{{ asset('storage/' . $request->sender->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-500">{{ strtoupper(substr($request->sender->name, 0, 1)) }}</span>
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('profile.show', $request->sender) }}" class="font-bold text-indigo-600 hover:underline">{{ $request->sender->name }}</a>
                                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $request->sender->user_type)) }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('friendships.update', $request) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-3 rounded shadow transition">
                                        {{ __('Accept') }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('friendships.update', $request) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-1 px-3 rounded shadow transition">
                                        {{ __('Refuse') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 italic text-sm text-center py-4">{{ __('No pending requests.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Friends List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('My Friends') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($friends as $friendship)
                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                @if($friendship->other_user->photo)
                                <img src="{{ asset('storage/' . $friendship->other_user->photo) }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center">
                                    <span class="text-indigo-400 font-bold">{{ strtoupper(substr($friendship->other_user->name, 0, 1)) }}</span>
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('profile.show', $friendship->other_user) }}" class="font-bold text-gray-800 hover:text-indigo-600 transition">{{ $friendship->other_user->name }}</a>
                                    <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $friendship->other_user->user_type)) }}</p>
                                </div>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('friendships.destroy', $friendship) }}" onsubmit="return confirm('Are you sure you want to remove this friend?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p class="col-span-3 text-gray-500 italic text-sm text-center py-8 bg-gray-50 rounded-xl">{{ __('You haven\'t added any friends yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>