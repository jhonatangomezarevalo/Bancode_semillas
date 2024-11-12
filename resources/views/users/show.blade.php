@extends('layouts.app')

@section('content')
    <h1>Perfil de {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Ubicación: {{ $user->ubicacion }}</p>
    <p>Municipio: {{ $user->municipio }}</p>
    @if($user->foto_perfil)
        <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto de perfil de {{ $user->name }}">
    @endif

    <h2>Semillas</h2>
    @foreach ($semillas as $semilla)
        <div>
            <h3><a href="{{ route('semillas.show', $semilla->id) }}">{{ $semilla->nombre }}</a></h3>
            <p>{{ $semilla->descripcion }}</p>
        </div>
    @endforeach

    {{ $semillas->links() }}

    @auth
        @if(auth()->id() === $user->id)
            <a href="{{ route('users.edit') }}">Editar Perfil</a>
        @endif
    @endauth
@endsection

