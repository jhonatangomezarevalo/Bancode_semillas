<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Nuevo Mensaje</title>
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
            --hover-color: #004d26;
            --border-color: #ddd;
            --sidebar-width: 200px;
            --content-max-width: 600px;
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
            width: var(--sidebar-width);
            background: var(--primary-color);
            padding: 20px 10px;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            overflow-y: auto;
        }
        .sidebar h2 {
            font-size: 20px;
            color: white;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .sidebar a i {
            margin-right: 12px;
        }
        .sidebar a:hover {
            background-color: var(--hover-color);
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            width: calc(100% - var(--sidebar-width));
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            min-height: 100vh;
        }
        .form-container {
            width: 100%;
            max-width: var(--content-max-width);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .form-container label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }
        .form-container select, .form-container textarea, .form-container input[type="file"] {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 14px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .form-container button:hover {
            background: var(--hover-color);
        }
        .search-input {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 14px;
        }
        .user-list {
            display: none;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            margin-top: 5px;
        }
        .user-list li {
            padding: 10px;
            cursor: pointer;
        }
        .user-list li:hover {
            background-color: var(--hover-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barra lateral -->
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

        <!-- Contenido principal -->
        <div class="main-content">
            <div class="form-container">
                <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="receiver_id">Destinatario</label>

                    <!-- Campo de búsqueda -->
                    <input type="text" class="search-input" id="search" placeholder="Buscar usuario..." onkeyup="filterUsers()" />

                    <!-- Lista de usuarios (oculta inicialmente) -->
                    <ul id="userList" class="user-list">
                        @foreach ($users as $user)
                            @if (in_array($user->role_id, [1, 2, 3, 6])) <!-- Verifica si el role_id está entre 1, 2 y 3 -->
                                <li data-id="{{ $user->id }}">{{ $user->name }}</li>
                            @endif
                        @endforeach
                    </ul>

                    <label for="photo">Foto (opcional)</label>
                    <input type="file" name="photo" accept="image/*">

                    <label for="message">Mensaje</label>
                    <textarea name="message" required></textarea>

                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function filterUsers() {
            const searchInput = document.getElementById("search").value.toLowerCase();
            const userList = document.getElementById("userList");
            const users = userList.getElementsByTagName("li");

            // Mostrar lista de usuarios si se escribe algo
            if (searchInput.length > 0) {
                userList.style.display = "block";
            } else {
                userList.style.display = "none";
            }

            // Mostrar/ocultar usuarios
            for (let i = 0; i < users.length; i++) {
                const userName = users[i].textContent.toLowerCase();
                if (userName.includes(searchInput)) {
                    users[i].style.display = "block";
                } else {
                    users[i].style.display = "none";
                }
            }
        }

        // Seleccionar un usuario al hacer clic
        document.querySelectorAll('.user-list li').forEach(item => {
            item.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                document.getElementById("search").value = this.textContent;
                document.getElementById("userList").style.display = "none"; // Ocultar lista de usuarios
            });
        });
    </script>
</body>
</html>
