<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de incluir el modelo User

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function profile()
    {
        return view('settings.profile');
    }

    public function updateProfile(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'profile_photo_path' => 'nullable|image|max:2048', // Para la imagen de perfil
        ]);

        $user = auth()->user(); // Obtén el usuario autenticado

        // Si hay una nueva foto de perfil, guárdala
        if ($request->hasFile('profile_photo_path')) {
            // Eliminar la foto anterior si existe
            if ($user->profile_photo_path) {
                \Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Almacena la nueva foto de perfil y actualiza el campo
            $user->profile_photo_path = $request->file('profile_photo_path')->store('profile_photos', 'public');
        }

        // Actualiza otros campos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        // Guarda los cambios
        $user->save();

        // Redirige de vuelta a la configuración de perfil con un mensaje de éxito
        return redirect()->route('settings.index')->with('success', 'Perfil actualizado exitosamente.');
    }

    public function notifications()
    {
        return view('settings.notifications');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $user->new_messages = $request->new_messages ? true : false;
        $user->new_seeds = $request->new_seeds ? true : false;
        $user->friend_requests = $request->friend_requests ? true : false;
        $user->save();

        return redirect()->route('settings.notifications')->with('status', 'Notificaciones actualizadas.');
    }

    // Información de cuenta
    public function account()
    {
        return view('settings.account');
    }

    public function updateAccount(Request $request)
{
    $request->validate([
        'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        'username' => 'required|string|max:255',
    ]);

        $user = Auth::user();
        $user->email = $request->input('email');
        $user->name = $request->input('username');
        $user->save();

        return redirect()->route('settings.account')->with('status', 'Información de cuenta actualizada.');
    }


    // Configuración de seguridad
    public function security()
    {
        return view('settings.security');
    }

    public function updateSecurity(Request $request)
    {
        // Validación para la nueva contraseña y su confirmación
        $request->validate([
            'password' => 'required|string|min:8|confirmed',  // Validación de la nueva contraseña
        ]);

        // Obtiene al usuario autenticado
        $user = Auth::user();

        // Actualiza la contraseña del usuario
        $user->password = bcrypt($request->password);  // Hashea la nueva contraseña
        $user->save();  // Guarda los cambios

        // Redirige con un mensaje de éxito
        return redirect()->route('settings.security')->with('status', 'Contraseña actualizada exitosamente.');
    }


    // Preferencias de idioma
    public function language()
    {
        return view('settings.language');
    }

    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:es,en',  // Solo se permiten idiomas 'es' o 'en'
        ]);

        $user = Auth::user();
        $user->language = $request->language;
        $user->save();

        // Cambia el idioma de la aplicación
        app()->setLocale($request->language);

        return redirect()->route('settings.language')->with('status', 'Idioma actualizado.');
}


    // Desactivación de cuenta
    public function deactivate()
    {
        return view('settings.deactivate');
    }

        public function deactivateAccount(Request $request)
    {
        $user = Auth::user();
        $user->delete();

        return redirect()->route('home')->with('status', 'Cuenta desactivada correctamente.');
    }


}
