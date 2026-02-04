<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil Candidat (CV)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status') === 'profile-updated')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ __('Profil mis à jour avec succès.') }}</span>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erreurs de validation:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form method="post" action="{{ route('job-seeker.profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- 1. General Info -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Informations Générales') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Renseignez votre titre de profil et votre niveau d'expérience.") }}
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div>
                                <x-input-label for="specialty" :value="__('Titre du profil (ex: Développeur Fullstack)')" />
                                <x-text-input id="specialty" name="specialty" type="text" class="mt-1 block w-full" :value="old('specialty', $jobSeeker->specialty)" required autofocus autocomplete="specialty" />
                                <x-input-error class="mt-2" :messages="$errors->get('specialty')" />
                            </div>

                            <div>
                                <x-input-label for="experience_level" :value="__('Niveau d\'expérience')" />
                                <select id="experience_level" name="experience_level" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Junior" {{ old('experience_level', $jobSeeker->experience_level) == 'Junior' ? 'selected' : '' }}>Junior (0-2 ans)</option>
                                    <option value="Intermédiaire" {{ old('experience_level', $jobSeeker->experience_level) == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire (2-5 ans)</option>
                                    <option value="Sénior" {{ old('experience_level', $jobSeeker->experience_level) == 'Sénior' ? 'selected' : '' }}>Sénior (5+ ans)</option>
                                    <option value="Expert" {{ old('experience_level', $jobSeeker->experience_level) == 'Expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('experience_level')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Skills -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-7xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Compétences') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Ajoutez vos compétences (ex: Laravel, VueJS, Gestion de projet). Appuyez sur Entrée pour ajouter.") }}
                            </p>
                        </header>

                        <div class="mt-6"
                            x-data="{ 
                                tags: {{ \Illuminate\Support\Js::from($jobSeeker->skills->pluck('name')) }},
                                newTag: '',
                                addTag() { 
                                    let tag = this.newTag.trim();
                                    if (tag !== '' && !this.tags.includes(tag)) {
                                        this.tags.push(tag);
                                    }
                                    this.newTag = '';
                                },
                                removeTag(index) {
                                    this.tags.splice(index, 1);
                                }
                             }">

                            <!-- Hidden input to send data -->
                            <input type="hidden" name="skills" :value="JSON.stringify(tags)">

                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <template x-for="(tag, index) in tags" :key="index">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        <span x-text="tag"></span>
                                        <button type="button" @click="removeTag(index)" class="ml-2 inline-flex items-center justify-center w-4 h-4 text-indigo-400 hover:text-indigo-600 focus:outline-none">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-3 w-3" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                            </div>

                            <div class="relative">
                                <x-text-input
                                    type="text"
                                    x-model="newTag"
                                    @keydown.enter.prevent="addTag()"
                                    @keydown.comma.prevent="addTag()"
                                    class="block w-full"
                                    placeholder="Ajouter une compétence..."
                                    list="skills-list" />
                                <datalist id="skills-list">
                                    @foreach($allSkills as $skill)
                                    <option value="{{ $skill->name }}">
                                        @endforeach
                                </datalist>
                                <button type="button" @click="addTag()" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Appuyez sur Entrée ou Virgule pour valider.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                        </div>
                    </div>
                </div>

                <!-- 3. Experience (Alpine Repeater) -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                    x-data="{ 
                        experiences: {{ \Illuminate\Support\Js::from($jobSeeker->experiences->isEmpty() ? [['id' => null, 'position' => '', 'company_name' => '', 'location' => '', 'start_date' => '', 'end_date' => '', 'description' => '']] : $jobSeeker->experiences->map(fn($exp) => ['id' => $exp->id, 'position' => $exp->position, 'company_name' => $exp->company_name, 'location' => $exp->location, 'start_date' => $exp->start_date?->format('Y-m-d') ?? '', 'end_date' => $exp->end_date?->format('Y-m-d') ?? '', 'description' => $exp->description])) }},
                        add() { this.experiences.push({ id: null, position: '', company_name: '', location: '', start_date: '', end_date: '', description: '' }); },
                        remove(index) { this.experiences.splice(index, 1); }
                     }">
                    <div class="max-w-7xl">
                        <header class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Expériences Professionnelles') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __("Détaillez votre parcours professionnel.") }}
                                </p>
                            </div>
                            <button type="button" @click="add()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('+ Ajouter une expérience') }}
                            </button>
                        </header>

                        <div class="mt-6 space-y-6">
                            <template x-for="(exp, index) in experiences" :key="index">
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 relative">
                                    <button type="button" @click="remove(index)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm font-bold">
                                        &times; Supprimer
                                    </button>

                                    <!-- Hidden ID -->
                                    <input type="hidden" :name="'experiences[' + index + '][id]'" x-model="exp.id">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label :value="__('Poste')" />
                                            <input type="text" :name="'experiences[' + index + '][position]'" x-model="exp.position" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="ex: Développeur Laravel">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Entreprise')" />
                                            <input type="text" :name="'experiences[' + index + '][company_name]'" x-model="exp.company_name" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="ex: Acme Corp">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Date de début')" />
                                            <input type="date" :name="'experiences[' + index + '][start_date]'" x-model="exp.start_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Date de fin (Laisser vide si en cours)')" />
                                            <input type="date" :name="'experiences[' + index + '][end_date]'" x-model="exp.end_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label :value="__('Description')" />
                                            <textarea :name="'experiences[' + index + '][description]'" x-model="exp.description" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Décrivez vos missions..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="experiences.length === 0" class="text-center text-gray-500 py-4">
                                {{ __('Aucune expérience ajoutée.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Education (Alpine Repeater) -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"
                    x-data="{ 
                        educations: {{ \Illuminate\Support\Js::from($jobSeeker->educations->isEmpty() ? [['id' => null, 'school' => '', 'degree' => '', 'field_of_study' => '', 'start_date' => '', 'end_date' => '', 'description' => '']] : $jobSeeker->educations->map(fn($edu) => ['id' => $edu->id, 'school' => $edu->school, 'degree' => $edu->degree, 'field_of_study' => $edu->field_of_study, 'start_date' => $edu->start_date?->format('Y-m-d') ?? '', 'end_date' => $edu->end_date?->format('Y-m-d') ?? '', 'description' => $edu->description])) }},
                        add() { this.educations.push({ id: null, school: '', degree: '', field_of_study: '', start_date: '', end_date: '', description: '' }); },
                        remove(index) { this.educations.splice(index, 1); }
                     }">
                    <div class="max-w-7xl">
                        <header class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Formation / Études') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __("Vos diplômes et certifications.") }}
                                </p>
                            </div>
                            <button type="button" @click="add()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('+ Ajouter une formation') }}
                            </button>
                        </header>

                        <div class="mt-6 space-y-6">
                            <template x-for="(edu, index) in educations" :key="index">
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50 relative">
                                    <button type="button" @click="remove(index)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-sm font-bold">
                                        &times; Supprimer
                                    </button>

                                    <!-- Hidden ID -->
                                    <input type="hidden" :name="'educations[' + index + '][id]'" x-model="edu.id">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label :value="__('École / Institut')" />
                                            <input type="text" :name="'educations[' + index + '][school]'" x-model="edu.school" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="ex: Université de Paris">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Diplôme')" />
                                            <input type="text" :name="'educations[' + index + '][degree]'" x-model="edu.degree" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="ex: Master">
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label :value="__('Domaine d\'étude')" />
                                            <input type="text" :name="'educations[' + index + '][field_of_study]'" x-model="edu.field_of_study" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="ex: Informatique">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Date de début')" />
                                            <input type="date" :name="'educations[' + index + '][start_date]'" x-model="edu.start_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <x-input-label :value="__('Date de fin')" />
                                            <input type="date" :name="'educations[' + index + '][end_date]'" x-model="edu.end_date" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="educations.length === 0" class="text-center text-gray-500 py-4">
                                {{ __('Aucune formation ajoutée.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Enregistrer le profil') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>