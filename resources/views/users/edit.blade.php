@extends('layouts.app')

@section('content')
    <h1>Editar Perfil</h1>
    <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" value="{{ $user->name }}" required>
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $user->email }}" required>
        
        <label for="ubicacion">Ubicación</label>
        <input type="text" name="ubicacion" id="ubicacion" value="{{ $user->ubicacion }}" required>
        
        <label for="municipio">Municipio</label>
        <input type="text" name="municipio" id="municipio" value="{{ $user->municipio }}" required>
        
        <label for="foto_perfil">Foto de Perfil</label>
        <input type="file" name="foto_perfil" id="foto_perfil">

        <button type="submit">Actualizar</button>
    </form>

    <form action="{{ route('users.update-password') }}" method="POST">
        @csrf
        @method('PUT')
        <label for="current_password">Contraseña Actual</label>
        <input type="password" name="current_password" id="current_password" required>

        <label for="password">Nueva Contraseña</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Actualizar Contraseña</button>
    </form>
@endsection
