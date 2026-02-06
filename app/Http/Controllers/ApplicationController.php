<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use App\Models\JobSeeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Store a new application from a job seeker.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isJobSeeker()) {
            abort(403, 'Only job seekers can apply for jobs.');
        }

        $jobSeeker = $user->jobSeeker;
        if (!$jobSeeker) {
            return redirect()->route('job-seeker.profile.edit')->with('error', 'Please complete your profile before applying.');
        }

        $request->validate([
            'job_offer_id' => 'required|exists:job_offers,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $jobOffer = JobOffer::findOrFail($request->job_offer_id);

        if ($jobOffer->status !== 'open') {
            return back()->with('error', 'This job offer is no longer open.');
        }

        // Check if already applied
        $existing = Application::where('job_offer_id', $jobOffer->id)
            ->where('job_seeker_id', $jobSeeker->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied for this position.');
        }

        Application::create([
            'job_offer_id' => $jobOffer->id,
            'job_seeker_id' => $jobSeeker->id,
            'status' => 'pending',
            'message' => $request->message,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }

    /**
     * Update the status of an application (Recruiter only).
     */
    public function updateStatus(Request $request, Application $application)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isRecruiter() || $application->jobOffer->recruiter_id !== $user->recruiter->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected,pending',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated to ' . $request->status . '.');
    }
}
