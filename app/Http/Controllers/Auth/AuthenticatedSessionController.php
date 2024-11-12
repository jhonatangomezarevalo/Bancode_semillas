<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    // Este método ya no es necesario si usas Jetstream/Fortify, pero si necesitas mostrar un formulario personalizado, puedes dejarlo.
    public function create()
    {
        return view('auth.login'); // Asegúrate de que la vista de login exista y esté configurada correctamente.
    }

    // Este método es para manejar el inicio de sesión
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        // Si las credenciales son correctas, el usuario será autenticado y la sesión será regenerada
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Regenerar la sesión para evitar fijación de sesión
            return redirect()->intended('/home'); // Redirige al usuario a la página deseada después de iniciar sesión
        }

        // Si las credenciales son incorrectas, se lanza una excepción
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas son incorrectas.'],
        ]);
    }

    // Este método se usa para cerrar la sesión del usuario
    public function destroy(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario
        $request->session()->invalidate(); // Invalida la sesión
        $request->session()->regenerateToken(); // Regenera el token de sesión para evitar ataques CSRF

        return redirect('/'); // Redirige a la página principal después de cerrar sesión
    }
}
