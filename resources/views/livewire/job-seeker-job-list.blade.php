<div>
    <div class="mb-6">
        <input wire:model.live="search" type="text" placeholder="Search for jobs or companies..." class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
    </div>

    @if($jobOffers->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">No open job offers found matching your criteria.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($jobOffers as $offer)
        <div wire:key="job-{{ $offer->id }}" class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-100 transition hover:shadow-md">
            @if($offer->image_path)
            <img src="{{ asset('storage/' . $offer->image_path) }}" alt="{{ $offer->title }}" class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400">
                No Image
            </div>
            @endif

            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $offer->title }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $offer->contract_type }}
                    </span>
                </div>

                <p class="text-brand-primary font-semibold text-sm mb-4">{{ $offer->company_name }}</p>

                <div class="flex items-center text-slate-500 text-sm mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $offer->location ?? 'Remote' }}
                </div>

                <p class="text-slate-600 text-sm line-clamp-3 mb-6">
                    {{ $offer->description }}
                </p>

                <div class="flex items-center justify-between">
                    <span class="text-slate-400 text-xs">{{ $offer->created_at->diffForHumans() }}</span>
                    <div class="flex space-x-2">
                        @if(in_array($offer->id, $appliedJobIds))
                        <span class="bg-green-100 text-green-700 text-sm font-bold py-2 px-4 rounded">
                            Applied
                        </span>
                        @else
                        <form action="{{ route('applications.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="job_offer_id" value="{{ $offer->id }}">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded transition">
                                Apply
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center min-h-[150px]">
        @if($hasMore)
        <div wire:intersect.always="loadMore" class="p-6 flex flex-col items-center">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-2"></div>
            <button wire:click="loadMore" class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition">
                Loading more jobs... (or click here)
            </button>
        </div>
        @else
        <div class="py-10 text-center">
            <p class="text-slate-400 font-medium">You've reached the end of the list.</p>
        </div>
        @endif
    </div>
    @endif
</div>