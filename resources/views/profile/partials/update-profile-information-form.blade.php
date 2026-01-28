<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="photo" :value="__('Profile Photo')" />
            @if ($user->photo)
            <div class="mt-2 mb-4">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" class="w-20 h-20 rounded-full object-cover">
            </div>
            @endif
            <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        @if ($user->user_type === 'recruiter')
        <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Company Information') }}</h3>

            <div class="space-y-6">
                <div>
                    <x-input-label for="company_name" :value="__('Company Name')" />
                    <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $user->recruiter->company_name ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                </div>

                <div>
                    <x-input-label for="company_size" :value="__('Company Size')" />
                    <x-text-input id="company_size" name="company_size" type="text" class="mt-1 block w-full" :value="old('company_size', $user->recruiter->company_size ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('company_size')" />
                </div>

                <div>
                    <x-input-label for="industry" :value="__('Industry')" />
                    <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry', $user->recruiter->industry ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('industry')" />
                </div>

                <div>
                    <x-input-label for="website" :value="__('Website')" />
                    <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $user->recruiter->website ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('website')" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Company Description')" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $user->recruiter->description ?? '') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>
        </div>
        @elseif ($user->user_type === 'job_seeker')
        <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Professional Information') }}</h3>

            <div class="space-y-6">
                <div>
                    <x-input-label for="specialty" :value="__('Specialty')" />
                    <x-text-input id="specialty" name="specialty" type="text" class="mt-1 block w-full" :value="old('specialty', $user->jobSeeker->specialty ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('specialty')" />
                </div>

                <div>
                    <x-input-label for="experience_level" :value="__('Experience Level')" />
                    <x-text-input id="experience_level" name="experience_level" type="text" class="mt-1 block w-full" :value="old('experience_level', $user->jobSeeker->experience_level ?? '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('experience_level')" />
                </div>

                <div>
                    <x-input-label for="skills" :value="__('Skills (Comma separated)')" />
                    <textarea id="skills" name="skills" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('skills', $user->jobSeeker->skills ?? '') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                </div>

                <div>
                    <x-input-label for="cv_path" :value="__('CV (PDF, DOC, DOCX)')" />
                    @if ($user->jobSeeker && $user->jobSeeker->cv_path)
                    <div class="mt-2 mb-2 text-sm text-gray-600">
                        <a href="{{ asset('storage/' . $user->jobSeeker->cv_path) }}" target="_blank" class="underline text-indigo-600">{{ __('View Current CV') }}</a>
                    </div>
                    @endif
                    <input id="cv_path" name="cv_path" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                    <x-input-error class="mt-2" :messages="$errors->get('cv_path')" />
                </div>
            </div>
        </div>
        @endif

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>