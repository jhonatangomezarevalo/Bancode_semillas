<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;  // IMPORTAR Request
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Redirigir al feed después del registro
    protected $redirectTo = '/feed';  // Puedes cambiar '/feed' a cualquier ruta de tu elección

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Obtener el rol basado en el nombre del rol
        $role = Role::where('name', $data['role'])->first();

        if (!$role) {
            throw new \Exception("El rol seleccionado no es válido.");
        }

        // Crear y almacenar el usuario
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'ubicacion' => $data['ubicacion'],
            'municipio' => $data['municipio'],
            'nombre_finca' => $data['role'] == 'Agricultor' ? $data['nombre_finca'] : null,
            'nombre_custodio' => $data['role'] == 'Custodio' ? $data['nombre_custodio'] : null,
            'nombre_casa_semillas' => $data['role'] == 'Casa de Semillas' ? $data['nombre_casa_semillas'] : null,
            'institucion_educativa' => ($data['role'] == 'Docente Académico' || $data['role'] == 'Estudiante') ? $data['institucion_educativa'] : null,
            'role_id' => $role->id,  // Aquí asignamos el id del rol seleccionado
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Validar los campos del formulario de registro
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
            'ubicacion' => ['required', 'string'],
            'municipio' => ['required', 'string'],
            // Validaciones para los campos específicos según el rol
            'nombre_finca' => $data['role'] == 'Agricultor' ? ['required', 'string'] : 'nullable',
            'nombre_custodio' => $data['role'] == 'Custodio' ? ['required', 'string'] : 'nullable',
            'nombre_casa_semillas' => $data['role'] == 'Casa de Semillas' ? ['required', 'string'] : 'nullable',
            'institucion_educativa' => ($data['role'] == 'Docente Académico' || $data['role'] == 'Estudiante') ? ['required', 'string'] : 'nullable',
        ]);
    }

    /**
     * Método para registrar al usuario.
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $this->validator($request->all())->validate();

        // Crear el usuario
        $user = $this->create($request->all());

        // Loguear al usuario
        auth()->login($user);

        // Redirigir al feed después del registro
        return redirect()->route('feed.index');
    }
}
