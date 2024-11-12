<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function viewFriends()
    {
        $userId = Auth::id();

        $friends = Friendship::where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->with(['friend', 'user'])
            ->get()
            ->map(function ($friendship) use ($userId) {
                return $friendship->user_id === $userId ? $friendship->friend : $friendship->user;
            });

        return view('friends.index', compact('friends'));
    }

    public function addFriend(Request $request, User $user)
    {
        // Asegúrate de que el usuario que está haciendo la solicitud no sea el mismo que el usuario al que está agregando como amigo
        if (auth()->user()->id === $user->id) {
            return response()->json(['error' => 'No puedes agregarte a ti mismo como amigo.'], 400);
        }

        // Lógica para agregar un amigo
        try {
            // Verificar si ya son amigos
            if (auth()->user()->is_friend_with($user)) {
                return response()->json(['message' => 'Ya son amigos.'], 400);
            }

            // Aquí, puedes agregar la lógica para guardar la relación de amistad
            auth()->user()->friends()->attach($user->id);

            return response()->json(['message' => 'Amigo agregado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un problema al agregar al amigo'], 500);
        }
    }


        public function removeFriend($friendId)
    {
        $userId = Auth::id();

        Friendship::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)
                  ->where('friend_id', $userId);
        })->delete();

        return response()->json(['success' => true, 'message' => 'Amigo eliminado.']);
    }
    
}
