<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recruiter = $this->ensureRecruiterProfile();
        $jobOffers = $recruiter->jobOffers()->latest()->get();
        return view('job_offers.index', compact('jobOffers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureRecruiterProfile();
        return view('job_offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recruiter = $this->ensureRecruiterProfile();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Full-time,Stage,Freelance',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job-offers', 'public');
        }

        // If company_name is not provided => fallback to recruiter's company name
        $companyName = $request->company_name ?? $recruiter->company_name;

        JobOffer::create([
            'recruiter_id' => $recruiter->id,
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => $companyName,
            'contract_type' => $request->contract_type,
            'image_path' => $imagePath,
            'location' => $request->location,
            'status' => 'open',
        ]);

        return redirect()->route('job-offers.index')->with('success', 'Job offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $jobOffer)
    {
        return view('job_offers.show', compact('jobOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $jobOffer)
    {
        $recruiter = $this->ensureRecruiterProfile();

        // checking
        if ($jobOffer->recruiter_id !== $recruiter->id) {
            abort(403);
        }
        return view('job_offers.edit', compact('jobOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        $recruiter = $this->ensureRecruiterProfile();

        if ($jobOffer->recruiter_id !== $recruiter->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'nullable|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Full-time,Stage,Freelance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($jobOffer->image_path) {
                Storage::disk('public')->delete($jobOffer->image_path);
            }
            $jobOffer->image_path = $request->file('image')->store('job-offers', 'public');
        }

        $jobOffer->update([
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => $request->company_name ?? $jobOffer->company_name,
            'contract_type' => $request->contract_type,
            'location' => $request->location,
        ]);

        return redirect()->route('job-offers.index')->with('success', 'Job offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        $recruiter = $this->ensureRecruiterProfile();

        if ($jobOffer->recruiter_id !== $recruiter->id) {
            abort(403);
        }

        if ($jobOffer->image_path) {
            Storage::disk('public')->delete($jobOffer->image_path);
        }

        $jobOffer->delete();

        return redirect()->route('job-offers.index')->with('success', 'Job offer deleted successfully.');
    }

    /**
     * Toggle the status of the job offer (open/closed).
     */
    public function toggleStatus(JobOffer $jobOffer)
    {
        $recruiter = $this->ensureRecruiterProfile();

        if ($jobOffer->recruiter_id !== $recruiter->id) {
            abort(403);
        }

        $jobOffer->status = $jobOffer->status === 'open' ? 'closed' : 'open';
        $jobOffer->save();

        $message = $jobOffer->status === 'open' ? 'Job offer opened.' : 'Job offer closed.';
        return back()->with('success', $message);
    }

    /**
     * Display the applications for a specific job offer.
     */
    public function showApplications(JobOffer $jobOffer)
    {
        $recruiter = $this->ensureRecruiterProfile();

        if ($jobOffer->recruiter_id !== $recruiter->id) {
            abort(403);
        }

        $applications = $jobOffer->applications()->with('jobSeeker.user')->latest()->get();

        return view('job_offers.applications', compact('jobOffer', 'applications'));
    }

    /**
     * Ensure the authenticated user has a recruiter profile.
     */
    private function ensureRecruiterProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isRecruiter()) {
            abort(403, 'Unauthorized. Only recruiters can access this area.');
        }

        return \App\Models\Recruiter::firstOrCreate(
            ['user_id' => $user->id],
            ['company_name' => $user->name . 'Unknown_Company'] // Default
        );
    }
}
