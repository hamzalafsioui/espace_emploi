<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applications for: ') }} {{ $jobOffer->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('job-offers.index') }}" class="text-blue-600 hover:underline">← Back to Job Offers</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($applications->isEmpty())
                    <p class="text-gray-500 text-center py-8">No applications received yet for this position.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Candidate
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Specialty
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Applied On
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            @if($application->jobSeeker->user->photo)
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <img class="w-full h-full rounded-full object-cover" src="{{ asset('storage/' . $application->jobSeeker->user->photo) }}" alt="" />
                                            </div>
                                            @endif
                                            <div class="ml-3">
                                                <p class="text-gray-900 font-medium">
                                                    {{ $application->jobSeeker->user->name }}
                                                </p>
                                                <p class="text-gray-600 text-xs">{{ $application->jobSeeker->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900">{{ $application->jobSeeker->specialty }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 italic">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('profile.show', $application->jobSeeker->user_id) }}" class="text-blue-600 hover:text-blue-900 font-medium">View Profile</a>

                                            @if($application->status === 'pending')
                                            <form action="{{ route('applications.update-status', $application) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Accept</button>
                                            </form>
                                            <form action="{{ route('applications.update-status', $application) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Reject</button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>