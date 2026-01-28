<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FriendshipController extends Controller
{
    /**
     * Display a listing of friend requests and friends.
     */
    public function index(Request $request): View
    {
        // get current logging user
        $user = $request->user();

        $pendingRequests = Friendship::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender')
            ->get();

        $friends = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'receiver'])
            ->get();

        return view('friendships.index', [
            'pendingRequests' => $pendingRequests,
            'friends' => $friends,
        ]);
    }

    /**
     * Send a friend request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        if ($request->user()->id === $request->receiver_id) {
            return back()->with('error', 'You cannot add yourself.');
        }

        // Check availability
        $exists = Friendship::where(function ($q) use ($request) {
            $q->where('sender_id', $request->user()->id)
                ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)
                ->where('receiver_id', $request->user()->id);
        })->exists();

        if ($exists) {
            return back()->with('status', 'Request already sent or users are already friends.');
        }

        Friendship::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Friend request sent!');
    }

    /**
     * Update Friendship | status
     */
    public function update(Request $request, Friendship $friendship): RedirectResponse
    {
        // check manual
        if ($request->user()->id !== $friendship->receiver_id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $friendship->update([
            'status' => $validated['status'],
        ]);

        return back()->with('status', 'Friend request ' . $validated['status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Friendship $friendship): RedirectResponse
    {
        // Manual check
        if ($request->user()->id !== $friendship->sender_id && $request->user()->id !== $friendship->receiver_id) {
            abort(403);
        }

        $friendship->delete();

        return back()->with('status', 'Friendship removed.');
    }
}
