<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Obtener conversación entre dos usuarios
    public function getConversation($contactId)
    {
        $userId = auth()->id(); // Obtener el ID del usuario autenticado

        // Obtener los mensajes entre el usuario autenticado y el contacto
        $messages = Message::where(function ($query) use ($userId, $contactId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $contactId);
        })
        ->orWhere(function ($query) use ($userId, $contactId) {
            $query->where('sender_id', $contactId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json([
            'messages' => $messages,
            'auth_user_id' => $userId
        ]);
    }

    // Enviar un mensaje
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string'
        ]);

        $message = new Message();
        $message->sender_id = auth()->id();
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->content;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }
}
