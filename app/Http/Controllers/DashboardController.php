<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Friendship;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        $recentActivity = [];

        if ($user->isJobSeeker()) {
            $jobSeeker = $user->jobSeeker;

            if ($jobSeeker) {
                $stats = [
                    [
                        'label' => 'Active Applications',
                        'value' => Application::where('job_seeker_id', $jobSeeker->id)->count(),
                        'icon' => 'fa-file-lines',
                        'bg' => 'bg-blue-50',
                        'color' => 'text-blue-600'
                    ],
                    [
                        'label' => 'Accepted Offers',
                        'value' => Application::where('job_seeker_id', $jobSeeker->id)->where('status', 'accepted')->count(),
                        'icon' => 'fa-check-circle',
                        'bg' => 'bg-green-50',
                        'color' => 'text-green-600'
                    ],
                    [
                        'label' => 'Connections',
                        'value' => Friendship::where(function ($query) use ($user) {
                            $query->where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id);
                        })->where('status', 'accepted')->count(),
                        'icon' => 'fa-users',
                        'bg' => 'bg-purple-50',
                        'color' => 'text-purple-600'
                    ],
                ];

                $recentActivity = Application::where('job_seeker_id', $jobSeeker->id)
                    ->with('jobOffer')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($app) {
                        return [
                            'title' => 'Applied to ' . $app->jobOffer->title,
                            'subtitle' => 'Status: ' . ucfirst($app->status),
                            'date' => $app->created_at->diffForHumans(),
                            'icon' => 'fa-paper-plane',
                        ];
                    });
            }
        } elseif ($user->isRecruiter()) {
            $recruiter = $user->recruiter;

            if ($recruiter) {
                $stats = [
                    [
                        'label' => 'Active Job Offers',
                        'value' => JobOffer::where('recruiter_id', $recruiter->id)->where('status', 'open')->count(),
                        'icon' => 'fa-briefcase',
                        'bg' => 'bg-blue-50',
                        'color' => 'text-blue-600'
                    ],
                    [
                        'label' => 'Total Applications',
                        'value' => Application::whereIn('job_offer_id', JobOffer::where('recruiter_id', $recruiter->id)->pluck('id'))->count(),
                        'icon' => 'fa-users-viewfinder',
                        'bg' => 'bg-amber-50',
                        'color' => 'text-amber-600'
                    ],
                    [
                        'label' => 'Connections',
                        'value' => Friendship::where(function ($query) use ($user) {
                            $query->where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id);
                        })->where('status', 'accepted')->count(),
                        'icon' => 'fa-users',
                        'bg' => 'bg-purple-50',
                        'color' => 'text-purple-600'
                    ],
                ];

                $recentActivity = Application::whereIn('job_offer_id', JobOffer::where('recruiter_id', $recruiter->id)->pluck('id'))
                    ->with(['jobOffer', 'jobSeeker.user'])
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($app) {
                        return [
                            'title' => $app->jobSeeker->user->name . ' applied for ' . $app->jobOffer->title,
                            'subtitle' => 'Candidate Specialty: ' . $app->jobSeeker->specialty,
                            'date' => $app->created_at->diffForHumans(),
                            'icon' => 'fa-user-plus',
                        ];
                    });
            }
        }

        return view('dashboard', compact('stats', 'recentActivity'));
    }
}
