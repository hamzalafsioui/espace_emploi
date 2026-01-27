<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhereHas('jobSeeker', function ($q) use ($search) {
                        $q->where('specialty', 'ilike', "%{$search}%");
                    });
            });
        }

        // Optional: Filter by type
        if ($request->filled('type')) {
            $query->where('user_type', $request->input('type'));
        }

        $users = $query->with(['recruiter', 'jobSeeker'])->paginate(10);

        return view('search.results', [
            'users' => $users,
        ]);
    }
}
