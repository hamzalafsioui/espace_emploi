<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}{{ __('\'s Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row items-center gap-8 mb-8">
                        <div>
                            @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 shadow-lg">
                            @else
                            <div class="w-32 h-32 rounded-full bg-indigo-50 border-4 border-indigo-100 flex items-center justify-center shadow-lg">
                                <span class="text-4xl text-indigo-300 font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="text-center md:text-left flex-1">
                            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $user->name }}</h3>
                            <p class="text-lg text-indigo-600 font-medium mb-4">{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}</p>

                            @if($user->bio)
                            <p class="text-gray-600 max-w-2xl italic">"{{ $user->bio }}"</p>
                            @endif
                        </div>

                        <div class="mt-4 md:mt-0">
                            @if(auth()->id() !== $user->id)

                            @if(!$friendship)
                            <form method="POST" action="{{ route('friendships.store') }}">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                <x-primary-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    {{ __('Add Friend') }}
                                </x-primary-button>
                            </form>
                            @elseif($friendship->status === 'pending' && $friendship->sender_id === auth()->id())
                            <span class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest cursor-default">
                                {{ __('Request Sent') }}
                            </span>
                            @elseif($friendship->status === 'pending' && $friendship->receiver_id === auth()->id())
                            <a href="{{ route('friendships.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('Respond to Request') }}
                            </a>
                            @elseif($friendship->status === 'accepted')
                            <span class="inline-flex items-center px-4 py-2 bg-green-100 border border-transparent rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest cursor-default">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Friends') }}
                            </span>
                            @endif
                            @else
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit Profile') }}
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                        @if ($user->user_type === 'recruiter' && $user->recruiter)
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                {{ __('Company Details') }}
                            </h4>
                            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Company Name') }}</p>
                                    <p class="text-gray-800 font-medium">{{ $user->recruiter->company_name }}</p>
                                </div>
                                @if($user->recruiter->industry)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Industry') }}</p>
                                    <p class="text-gray-800">{{ $user->recruiter->industry }}</p>
                                </div>
                                @endif
                                @if($user->recruiter->company_size)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Company Size') }}</p>
                                    <p class="text-gray-800">{{ $user->recruiter->company_size }}</p>
                                </div>
                                @endif
                                @if($user->recruiter->website)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Website') }}</p>
                                    <a href="{{ $user->recruiter->website }}" target="_blank" class="text-indigo-600 hover:underline">{{ $user->recruiter->website }}</a>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($user->recruiter->description)
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('About Company') }}
                            </h4>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $user->recruiter->description }}</p>
                            </div>
                        </div>
                        @endif

                        @elseif ($user->user_type === 'job_seeker' && $user->jobSeeker)
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('Professional Profile') }}
                            </h4>
                            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Specialty') }}</p>
                                    <p class="text-gray-800 font-medium">{{ $user->jobSeeker->specialty }}</p>
                                </div>
                                @if($user->jobSeeker->experience_level)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Experience Level') }}</p>
                                    <p class="text-gray-800">{{ $user->jobSeeker->experience_level }}</p>
                                </div>
                                @endif
                                @if($user->jobSeeker->cv_path)
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Curriculum Vitae') }}</p>
                                    <a href="{{ asset('storage/' . $user->jobSeeker->cv_path) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('Download CV') }}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($user->jobSeeker->skills->isNotEmpty())
                        <div class="space-y-4">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                {{ __('Skills & Expertise') }}
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->jobSeeker->skills as $skill)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full font-medium text-sm">
                                    {{ $skill->name }}
                                    @if($skill->pivot->level)
                                    <span class="text-xs text-indigo-400 ml-1">({{ $skill->pivot->level }})</span>
                                    @endif
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>

                    @if ($user->user_type === 'job_seeker' && $user->jobSeeker)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-12 mt-12 border-t border-gray-100">
                        {{-- Experiences --}}
                        <div class="space-y-6">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('Professional Experiences') }}
                            </h4>

                            @if($user->jobSeeker->experiences->isEmpty())
                            <p class="text-gray-400 italic">{{ __('No experiences listed.') }}</p>
                            @else
                            <div class="space-y-6">
                                @foreach($user->jobSeeker->experiences()->orderBy('start_date', 'desc')->get() as $exp)
                                <div class="relative pl-6 border-l-2 border-indigo-100">
                                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-indigo-500 rounded-full"></div>
                                    <h5 class="font-bold text-gray-900">{{ $exp->position }}</h5>
                                    <p class="text-indigo-600 font-medium text-sm">{{ $exp->company_name }} • {{ $exp->location }}</p>
                                    <p class="text-gray-400 text-xs mb-2">
                                        {{ $exp->start_date->format('M Y') }} — {{ $exp->end_date ? $exp->end_date->format('M Y') : __('Present') }}
                                    </p>
                                    @if($exp->description)
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $exp->description }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        {{-- Education --}}
                        <div class="space-y-6">
                            <h4 class="text-xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                {{ __('Education & Diplomas') }}
                            </h4>

                            @if($user->jobSeeker->educations->isEmpty())
                            <p class="text-gray-400 italic">{{ __('No education history listed.') }}</p>
                            @else
                            <div class="space-y-6">
                                @foreach($user->jobSeeker->educations()->orderBy('start_date', 'desc')->get() as $edu)
                                <div class="relative pl-6 border-l-2 border-indigo-100">
                                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-indigo-500 rounded-full"></div>
                                    <h5 class="font-bold text-gray-900">{{ $edu->degree }}</h5>
                                    <p class="text-indigo-600 font-medium text-sm">{{ $edu->field_of_study }}</p>
                                    <p class="text-gray-500 text-sm italic">{{ $edu->school }}</p>
                                    <p class="text-gray-400 text-xs mb-2">
                                        {{ $edu->start_date->format('Y') }} — {{ $edu->end_date ? $edu->end_date->format('Y') : __('Present') }}
                                    </p>
                                    @if($edu->description)
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $edu->description }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>