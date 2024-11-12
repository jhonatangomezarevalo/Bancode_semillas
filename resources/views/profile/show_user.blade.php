<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #555;
            --hover-color: #004d26;
            --border-color: #ddd;
            --input-border-color: #ccc;
            --input-focus-border-color: #009933;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .sidebar {
            width: 200px;
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

        .sidebar a i {
            margin-right: 15px;
            font-size: 18px;
        }

        .sidebar a:hover {
            color: var(--accent-color);
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .main-content {
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            background: white;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-y: auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-header img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-left: 20px;
            border: 5px solid var(--border-color);
        }

        .personal-info {
            flex: 1;
            font-size: 18px;
        }

        .personal-info h3 {
            margin-bottom: 10px;
            font-size: 15px;
            color: var(--primary-color);
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

        .button-container {
            display: flex;
            gap: 10px; 
            margin-top: 20px; 
        }

        .action-button {
            padding: 12px 25px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .action-button:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        .action-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 150, 0, 0.5);
        }

        .disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .no-posts {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: var(--light-text-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Banco de Semillas</h2>
            <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
            <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
            <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
            @endif
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
            <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
            @endif  
            <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>
        </div>

        <div class="main-content">
            <div class="profile-header">
                <div class="personal-info">
                    <h3>Información Personal</h3>
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p><strong>Rol:</strong> {{ $user->role->name }}</p>
                    @if($user->nombre_finca)
                        <p><strong>Finca:</strong> {{ $user->nombre_finca }}</p>
                    @endif
                    @if($user->nombre_custodio)
                        <p><strong>Custodio:</strong> {{ $user->nombre_custodio }}</p>
                    @endif
                    @if($user->nombre_casa_semillas)
                        <p><strong>Casa de Semillas:</strong> {{ $user->nombre_casa_semillas }}</p>
                    @endif
                    @if($user->institucion_educativa)
                        <p><strong>Institución Educativa:</strong> {{ $user->institucion_educativa }}</p>
                    @endif
                    <p><strong>Ubicación:</strong> {{ $user->ubicacion }}</p>
                    <p><strong>Municipio:</strong> {{ $user->municipio }}</p>
                </div>
                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil" class="profile-image">
            </div>


            <div class="button-container">
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
                <button class="action-button" onclick="location.href='{{ route('messages.create', ['recipient_id' => $user->id]) }}'">Enviar Mensaje</button>
            @endif
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
                    <div class="no-posts">No hay semillas para mostrar.</div>
                @endforelse
            </div>
        </div>
    </div>
    </body>

</html>