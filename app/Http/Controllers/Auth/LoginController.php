<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Asegúrate de que esta vista exista
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validar las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Redirigir al usuario después del inicio de sesión al feed
            return redirect()->intended('/feed');
        }

        // Si las credenciales son incorrectas, redirigir de nuevo con un error
        return redirect()->back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
