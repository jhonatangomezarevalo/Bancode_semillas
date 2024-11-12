<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendController extends Controller
{
    /**
     * Send a friend request to the specified user.
     */
    public function sendRequest(Request $request)
    {
        try {
            $friendId = $request->input('friend_id');
            $userId = auth()->id();

            // Verifica si ya existe una solicitud de amistad o una amistad
            if (FriendRequest::where('sender_id', $userId)->where('receiver_id', $friendId)->exists() ||
                Friendship::friendshipExists($userId, $friendId)) {
                return response()->json(['success' => false, 'message' => 'Ya existe una solicitud o amistad con este usuario.'], 400);
            }

            // Crear nueva solicitud de amistad
            $friendRequest = FriendRequest::create([
                'sender_id' => $userId,
                'receiver_id' => $friendId,
                'status' => 'pending',
            ]);

            return response()->json(['success' => true, 'message' => 'Solicitud de amistad enviada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error al enviar solicitud de amistad: '.$e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error al procesar la solicitud'], 500);
        }
    }

    /**
     * Accept a friend request.
     */
    public function acceptFriendRequest($requestId)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($requestId);

            // Crear la amistad
            Friendship::create([
                'user_id' => $friendRequest->sender_id,
                'friend_id' => $friendRequest->receiver_id,
                'status' => 'accepted',
            ]);

            // Eliminar la solicitud de amistad
            $friendRequest->delete();

            return response()->json(['message' => 'Solicitud de amistad aceptada correctamente.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Solicitud de amistad no encontrada.'], 404);
        }
    }

    /**
     * Reject a friend request.
     */
    public function rejectFriendRequest($requestId)
    {
        try {
            $friendRequest = FriendRequest::findOrFail($requestId);
            $friendRequest->status = 'rejected';
            $friendRequest->save();

            return response()->json(['message' => 'Solicitud de amistad rechazada correctamente.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Solicitud de amistad no encontrada.'], 404);
        }
    }

    /**
     * Remove a friend.
     */
    public function removeFriend($friendshipId)
    {
        try {
            $friendship = Friendship::findOrFail($friendshipId);
            $friendship->delete();

            return response()->json(['message' => 'Amigo eliminado correctamente.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Amistad no encontrada.'], 404);
        }
    }

    /**
     * Get the list of friends for the authenticated user.
     */
    public function getFriends()
    {
        $friends = Friendship::where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->with('friend') // Carga el modelo amigo
            ->get();

        return response()->json(['friends' => $friends]);
    }

    /**
     * Get the list of pending friend requests for the authenticated user.
     */
    public function getPendingRequests()
    {
        $pendingRequests = FriendRequest::where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->with('sender') // Carga el modelo remitente
            ->get();

        return response()->json(['pendingRequests' => $pendingRequests]);
    }
    public function addFriend(Request $request, $userId)
{
    $friend = User::find($userId);
    
    if (!$friend) {
        return response()->json(['message' => 'Usuario no encontrado.'], 404);
    }

    $user = auth()->user();

    if ($user->is_friend_with($friend)) {
        return response()->json(['message' => 'Ya son amigos.'], 400);
    }

    // Aquí agrega la lógica para crear la amistad, por ejemplo:
    $user->friends()->attach($friend->id);

    return response()->json(['message' => 'Amigo agregado con éxito.']);
}
}
