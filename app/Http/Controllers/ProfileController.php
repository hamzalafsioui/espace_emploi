<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's public profile.
     */
    public function show(User $user): View
    {
        $user->load(['recruiter', 'jobSeeker']);

        $friendship = Auth::check() ? Auth::user()->friendshipWith($user) : null;

        return view('profile.show', [
            'user' => $user,
            'friendship' => $friendship,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('images_profile', $filename, 'public');
            $user->photo = $path;
        }

        // Handle User type specific updates
        if ($user->user_type === 'recruiter') {
            $recruiterData = $request->only(['company_name', 'company_size', 'industry', 'website', 'description']);
            $user->recruiter()->updateOrCreate(['user_id' => $user->id], $recruiterData);
        } elseif ($user->user_type === 'job_seeker') {
            $jobSeekerData = $request->only(['specialty', 'experience_level', 'skills']);

            // Handle CV Upload
            if ($request->hasFile('cv_path')) {
                $cvFile = $request->file('cv_path');
                $cvFilename = time() . '_cv_' . $cvFile->getClientOriginalName();
                $cvPath = $cvFile->storeAs('cvs', $cvFilename, 'public');
                $jobSeekerData['cv_path'] = $cvPath;
            }

            $user->jobSeeker()->updateOrCreate(['user_id' => $user->id], $jobSeekerData);
        }

        // Fill other fields (name, email, bio)
        $user->fill($request->safe()->only(['name', 'email', 'bio']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
