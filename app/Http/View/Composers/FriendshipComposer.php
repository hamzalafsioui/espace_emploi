<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FriendshipComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $pendingCount = Auth::check() ? Auth::user()->pending_friendships_count : 0;

        $view->with('pendingFriendshipsCount', $pendingCount);
    }
}
