<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Feed</title>
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
            --content-max-width: 1000px; /* Ajusté este valor para mayor flexibilidad */
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
            margin-left: var(--sidebar-width);
            padding: 20px;
            width: calc(100% - var(--sidebar-width));
            background: white;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-y: auto;
        }
        .topbar {
            width: 100%;
            padding: 15px 0;
            display: flex;
            justify-content: center;
            border-bottom: 2px solid var(--border-color);
        }
        .search-bar {
            display: flex;
            align-items: center;
            position: relative;
            width: 100%;
            max-width: 650px;
        }
        .search-bar input[type="text"] {
            padding: 10px 40px 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            outline: none;
            transition: width 0.3s ease, opacity 0.3s ease;
            width: 0;
            opacity: 0;
            visibility: hidden;
        }
        .search-bar input[type="text"].active {
            width: 100%;
            opacity: 1;
            visibility: visible;
        }
        .search-bar i {
            font-size: 20px;
            color: var(--primary-color);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .search-bar i:hover {
            color: var(--accent-color);
        }
        .search-bar button {
            margin-left: 10px;
            padding: 10px 15px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-bar button:hover {
            background-color: var(--accent-color);
        }

        .post-container {
            width: 100%;
            max-width: var(--content-max-width); /* Ajusté el ancho máximo */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px; /* Espacio entre la barra de búsqueda y las publicaciones */
        }
        
        .post:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

       /* Contenedor principal de la publicación */
       .post {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: flex-start; /* Alineamos los elementos de la publicación */
            align-items: center;
            transition: box-shadow 0.3s ease;
            max-width: 900px; /* Maximo ancho para cada publicación */
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* Imagen de la semilla (a la izquierda) */
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

        /* Estilo para los títulos */
        .post-info h1 {
            font-size: 22px;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .post-info h2 {
            margin: 0 20px 10px 0;
            font-size: 22px;
            color: var(--primary-color);
            flex: 1;
        }
        .post-info p {
            margin: 0;
            font-size: 16px;
            color: var(--light-text-color);
            overflow-wrap: break-word; /* Asegura que el texto largo se ajuste */
            word-wrap: break-word;
            word-break: break-word; /* Garantiza que el texto largo se rompa correctamente */
        }

        .contact-button {
            margin-top: 10px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            align-self: flex-start;
        }
        .contact-button:hover {
            background-color: var(--accent-color);
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
        #disponible-filter {
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 50px;
            margin-left: 10px;
            outline: none;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Banco de Semillas</h2>
        <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
        @if (in_array(auth()->user()->role->name, ['Agricultor', 'Custodio', 'Casa de Semillas', 'Admin']))
            <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
            <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
        @endif   
        <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>

        @if (auth()->user()->role->name == 'Admin')
            <a href="{{ route('admin.index') }}"><i class="fas fa-home"></i> Ir a Admin</a>
        @endif


        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Cerrar sesión</button>
        </form>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="search-bar">
                <i class="fas fa-search" id="search-icon"></i>
                <form action="{{ route('feed.search') }}" method="GET" id="search-form">
                    <input type="text" name="query" placeholder="Buscar semillas..." id="search-input" value="{{ request('query') }}">
                    <select name="disponible" id="disponible-filter">
                        <option value="">Disponibilidad</option>
                        <option value="1" {{ request('disponible') == 'Sì' ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ request('disponible') == 'No' ? 'selected' : '' }}>No Disponible</option>
                    </select>
                    <button type="submit" id="search-button">Buscar</button>
                </form>
            </div>
        </div>

        <div class="post-container">
            @forelse ($inventories as $inventory)
                <div class="post">
                    <img src="{{ asset('storage/' . $inventory->image_path) }}" alt="Imagen de semilla" class="post-image">
                    <div class="post-info">
                        <h3>{{ $inventory->user->name }}</h3>
                        <h1>{{ $inventory->name }}</h1>
                        <p><strong>Tipo:</strong> {{ $inventory->type }}</p>
                        <p><strong>Informacion base:</strong> {{ $inventory->base_info }}</p>
                        <p><strong>Informacion de adaptabilidad:</strong> {{ $inventory->adaptable_info }}</p>
                        <p><strong>Informacion de trazabilidad:</strong> {{ $inventory->traceability_info }}</p>
                        <p><strong>Disponible:</strong> {{ $inventory->disponible}}</p>
                         <a href="{{ route('profile.show_user', $inventory->user_id) }}" class="contact-button">Contactar</a>

                    </div>
                </div>
            @empty
                <p>No se encontraron resultados para "{{ request('query') }}".</p>
            @endforelse
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const searchIcon = document.getElementById('search-icon');
        const searchForm = document.getElementById('search-form');

        searchIcon.addEventListener('click', function() {
            searchInput.classList.toggle('active');
            if (searchInput.classList.contains('active')) {
                searchInput.focus();
            }
        });

        searchForm.addEventListener('submit', function(e) {
            if (!searchInput.value) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
