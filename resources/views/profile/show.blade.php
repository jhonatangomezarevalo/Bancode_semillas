<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Banco de Semillas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos generales */
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #777;
            --hover-color: #004d26;
            --border-color: #ddd;
            --sidebar-width: 180px;
            --content-max-width: 800px;
        }
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            height: 100%;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            padding: 30px 10px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: white;
            box-sizing: border-box;
        }
        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            margin-bottom: 25px;
            font-size: 16px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .sidebar a:hover {
            color: var(--accent-color);
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            width: calc(100% - var(--sidebar-width));
            background: white;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
            max-width: 800px;
        }
        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 90px;
            object-fit: cover;
            margin-left: 20px;
        }
        .personal-info {
            text-align: left;
            max-width: 400px;
            margin-right: auto;
        }
        .post-container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .post {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: flex-start;
            transition: box-shadow 0.3s ease;
            max-width: 900px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word; /* Garantiza que el texto largo se rompa correctamente */
        }
        .post:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
        .post img {
            width: 150px; /* Tamaño uniforme para las imágenes */
            height: 150px; /* Tamaño uniforme para las imágenes */
            border-radius: 8px;
            margin-right: 20px;
            object-fit: cover; /* Mantener proporciones de la imagen */
        }
        .post-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 700px; /* Limita el ancho del texto */
        }
        .post h2 {
            margin: 0 20px 10px 0;
            font-size: 22px;
            color: var(--primary-color);
            flex: 1;
        }
        .post p {
            margin: 0;
            font-size: 16px;
            color: var(--light-text-color);
            overflow-wrap: break-word; /* Asegura que el texto largo se ajuste */
            word-wrap: break-word;
            word-break: break-word;
        }
        .logout-button {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Banco de Semillas</h2>
        <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
        @endif
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
        @endif  
        <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Cerrar sesión</button>
        </form>
    </div>

    <div class="main-content">
        <div class="profile-container">
            <div class="personal-info">
                <h2>Información Personal</h2>
                <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Ubicación:</strong> {{ $user->ubicacion }}</p>
                <p><strong>Municipio:</strong> {{ $user->municipio }}</p>
                <p><strong>Rol:</strong> {{ $user->role->name }}</p>
            </div>
            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil" class="profile-image">
        </div>

        <div class="post-container">
            @forelse ($inventories as $inventory)
                <div class="post">
                    <img src="{{ asset('storage/' . $inventory->image_path) }}" alt="Imagen de semilla" class="post-image">
                    <div class="post-info">
                        <h2>{{ $inventory->name }}</h2>
                        <p><strong>Tipo:</strong> {{ $inventory->type }}</p>
                        <p><strong>Informacion base:</strong> {{ $inventory->base_info }}</p>
                        <p><strong>Informacion de adaptabilidad:</strong> {{ $inventory->adaptable_info }}</p>
                        <p><strong>Informacion de trazabilidad:</strong> {{ $inventory->traceability_info }}</p>
                        <p><strong>Disponible:</strong> {{ $inventory->disponible}}</p>
                    </div>
                </div>
            @empty
                <p>No hay publicaciones.</p>
            @endforelse
        </div>
    </div>
</body>
</html>
