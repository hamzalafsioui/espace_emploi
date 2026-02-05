<?php

namespace App\Livewire;

use App\Models\JobOffer;
use Livewire\Component;
use Livewire\Attributes\Lazy;

#[Lazy]
class JobSeekerJobList extends Component
{
    public $limit = 12;
    public $step = 6;
    public $hasMore = true;
    public $search = '';
    public $appliedJobIds = [];

    public function updatingSearch()
    {
        $this->reset(['limit', 'hasMore']);
        $this->limit = 12;
    }

    public function loadMore()
    {
        $this->limit += $this->step;
    }

    public function render()
    {
        $query = JobOffer::where('status', 'open')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('title', 'like', "%{$this->search}%")
                        ->orWhere('company_name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            });

        // Fetch one extra to check for more pages without an extra count query
        $results = $query->latest()
            ->take($this->limit + 1)
            ->get();

        $this->hasMore = $results->count() > $this->limit;

        if (auth()->check() && auth()->user()->isJobSeeker() && auth()->user()->jobSeeker) {
            $this->appliedJobIds = auth()->user()->jobSeeker->applications()->pluck('job_offer_id')->toArray();
        }

        return view('livewire.job-seeker-job-list', [
            'jobOffers' => $results->take($this->limit),
        ]);
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-pulse">
            <div class="bg-gray-100 h-64 rounded-xl"></div>
            <div class="bg-gray-100 h-64 rounded-xl"></div>
            <div class="bg-gray-100 h-64 rounded-xl"></div>
        </div>
        HTML;
    }
}
