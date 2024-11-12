<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function viewRequests()
    {
        $userId = Auth::id();
        $requests = FriendRequest::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with('sender')
            ->get();

        return view('friend_requests.index', compact('requests'));
    }

    public function acceptRequest($requestId)
    {
        $request = FriendRequest::findOrFail($requestId);

        Friendship::create([
            'user_id' => $request->receiver_id,
            'friend_id' => $request->sender_id,
            'status' => 'accepted',
        ]);

        $request->delete();
        return back()->with('status', 'Solicitud aceptada.');
    }

    public function rejectRequest($requestId)
    {
        $request = FriendRequest::findOrFail($requestId);
        $request->update(['status' => 'rejected']);
        return back()->with('status', 'Solicitud rechazada.');
    }
    
}
