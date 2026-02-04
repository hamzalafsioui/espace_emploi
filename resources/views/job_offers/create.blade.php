<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Job Offer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('job-offers.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Job Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name', Auth::user()->recruiter->company_name ?? '')" placeholder="Defaults to your company name" />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <!-- Contract Type -->
                        <div>
                            <x-input-label for="contract_type" :value="__('Contract Type')" />
                            <select id="contract_type" name="contract_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select a contract type</option>
                                <option value="CDI" {{ old('contract_type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                <option value="CDD" {{ old('contract_type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="Full-time" {{ old('contract_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Stage" {{ old('contract_type') == 'Stage' ? 'selected' : '' }}>Stage (Internship)</option>
                                <option value="Freelance" {{ old('contract_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                            <x-input-error :messages="$errors->get('contract_type')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div>
                            <x-input-label for="image" :value="__('Image (Mandatory)')" />
                            <input id="image" type="file" name="image" accept="image/*" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('job-offers.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Create Offer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>