<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Muestra todas las conversaciones del usuario autenticado.
     */
    public function index()
    {
        $userId = Auth::id();

        // Obtenemos los usuarios con los que el usuario autenticado ha tenido mensajes
        $contacts = User::whereHas('receivedMessages', function ($query) use ($userId) {
            $query->where('sender_id', $userId);
        })->orWhereHas('sentMessages', function ($query) use ($userId) {
            $query->where('receiver_id', $userId);
        })->get();

        return view('messages.index', compact('contacts'));
    }

    /**
     * Muestra la conversación específica entre el usuario autenticado y un contacto.
     *
     * @param  int  $contactId
     * @return \Illuminate\Http\Response
     */
    public function showConversation($contactId)
    {
        $authUserId = Auth::id();
        $contact = User::findOrFail($contactId);

        // Obtenemos los mensajes de la conversación ordenados por fecha
        $messages = Message::where(function ($query) use ($authUserId, $contactId) {
            $query->where('sender_id', $authUserId)->where('receiver_id', $contactId);
        })->orWhere(function ($query) use ($authUserId, $contactId) {
            $query->where('sender_id', $contactId)->where('receiver_id', $authUserId);
        })->orderBy('created_at', 'asc')->get();

        // Añadir la URL completa de las fotos si existen
        foreach ($messages as $message) {
            if ($message->photo) {
                $message->photo_url = Storage::url($message->photo);
            } else {
                $message->photo_url = null;
            }
        }

        return response()->json([
            'messages' => $messages,
            'auth_user_id' => $authUserId,
            'contact' => $contact
        ]);
    }

    /**
     * Almacena un mensaje nuevo en la conversación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        // Crear el mensaje
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;

        // Manejar la foto si existe
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('messages', 'public');
            $message->photo = $path;
        }

        $message->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->message,
                'photo' => $message->photo ? Storage::url($message->photo) : null,
                'sender_id' => $message->sender_id,
                'created_at' => $message->created_at->format('Y-m-d H:i:s')
            ]);
        }

        // Si la solicitud no es AJAX (desde la vista create), redirigir al index
        return redirect()->route('messages.index')->with('success', 'Mensaje enviado con éxito');
    }

    /**
     * Muestra el formulario para crear un nuevo mensaje.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Filtrar los usuarios según el role_id
        $users = User::whereIn('role_id', [1, 2, 3, 6])->get(); // Filtra usuarios con los roles adecuados

        return view('messages.create', compact('users'));
    }
}
