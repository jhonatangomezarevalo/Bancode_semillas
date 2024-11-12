<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Configuración</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #777;
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
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
            overflow-y: auto;
        }

        .topbar {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            text-align: center; /* Centra el título de la barra superior */
        }

        .config-container {
            margin-top: 20px;
            text-align: center; /* Centra el texto y los botones */
        }

        .config-container h2,
        .config-container p {
            text-align: center; /* Centra el título y el párrafo */
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
            margin: 0 auto; /* Centra los botones horizontalmente */
        }

        .button {
            background: var(--secondary-color);
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .button:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
        }

        .button:active {
            transform: translateY(1px);
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
        <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas'|| auth()->user()->role->name == 'Admin')
        <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
        @endif
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas'|| auth()->user()->role->name == 'Admin')
        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
        @endif  
        <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Cerrar sesión</button>
        </form>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h2>Configuración de la Cuenta</h2>
        </div>

        <div class="config-container">
            <h2>Bienvenido a Configuración</h2>
            <p>Utiliza las diferentes opciones de configuración para navegar por las diferentes secciones de configuración.</p>
            <div class="button-container">
                <a href="{{ route('settings.profile') }}" class="button">Actualizar Perfil</a>
                <a href="{{ route('settings.security') }}" class="button">Seguridad</a>
                <a href="{{ route('settings.account') }}" class="button">Informacion de la cuenta</a>
                <a href="{{ route('settings.deactivate') }}" class="button">Eliminar cuenta</a>
            </div>
        </div>
    </div>
</body>
</html>
