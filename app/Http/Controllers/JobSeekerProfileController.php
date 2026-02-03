<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use App\Models\Skill;
use Illuminate\Http\Request;

class JobSeekerProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        // Get or create job seeker profile
        $jobSeeker = JobSeeker::with(['skills', 'experiences', 'educations'])
            ->firstOrCreate(
                ['user_id' => $user->id],
                ['specialty' => '', 'experience_level' => 'Junior']
            );

        // If it was just created, load the relationships
        if (!$jobSeeker->relationLoaded('skills')) {
            $jobSeeker->load(['skills', 'experiences', 'educations']);
        }

        return view('job_seeker.profile.edit', [
            'jobSeeker' => $jobSeeker,
            'allSkills' => Skill::all()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Get the job seeker profile
        $jobSeeker = JobSeeker::where('user_id', $user->id)->firstOrFail();

        // Validate all data
        $validated = $request->validate([
            'specialty' => 'required|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'experiences' => 'array',
            'experiences.*.id' => 'nullable|integer|exists:experiences,id',
            'experiences.*.position' => 'required|string|max:255',
            'experiences.*.company_name' => 'required|string|max:255',
            'experiences.*.location' => 'nullable|string|max:255',
            'experiences.*.start_date' => 'required|date',
            'experiences.*.end_date' => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.description' => 'nullable|string',
            'educations' => 'array',
            'educations.*.id' => 'nullable|integer|exists:educations,id',
            'educations.*.school' => 'required|string|max:255',
            'educations.*.degree' => 'required|string|max:255',
            'educations.*.field_of_study' => 'required|string|max:255',
            'educations.*.start_date' => 'nullable|date',
            'educations.*.end_date' => 'nullable|date|after_or_equal:educations.*.start_date',
            'educations.*.description' => 'nullable|string',
        ]);

        // Update basic profile info
        $jobSeeker->update([
            'specialty' => $validated['specialty'],
            'experience_level' => $validated['experience_level'],
        ]);

        // Sync skills
        $this->syncSkills($jobSeeker, $validated['skills'] ?? null);

        // Sync experiences
        $this->syncRelation($jobSeeker->experiences(), $validated['experiences'] ?? []);

        // Sync educations
        $this->syncRelation($jobSeeker->educations(), $validated['educations'] ?? []);

        return redirect()
            ->route('job-seeker.profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Sync skills from JSON string
     */
    private function syncSkills(JobSeeker $jobSeeker, ?string $skillsJson): void
    {
        if (empty($skillsJson)) {
            $jobSeeker->skills()->sync([]);
            return;
        }

        $skillNames = json_decode($skillsJson, true) ?: [];

        $skillIds = collect($skillNames)
            ->map(fn($name) => trim($name))
            ->filter()
            ->map(fn($name) => Skill::firstOrCreate(['name' => $name])->id)
            ->toArray();


        $jobSeeker->skills()->sync($skillIds);
    }

    /**
     * Sync hasMany relationship (experiences or educations)
     */
    private function syncRelation($relation, array $items): void
    {
       
    }
}
