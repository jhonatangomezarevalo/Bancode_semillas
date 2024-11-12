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
            --hover-color: #004d26;
        }
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            height: 100vh;
            box-sizing: border-box;
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
            text-align: center;
        }

        .config-container {
            margin-top: 20px;
            text-align: center;
        }

        .config-container h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .config-container p {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .config-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
        }

        .config-container form div {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .config-container form label {
            color: var(--text-color);
            font-weight: 500;
            margin-bottom: 5px;
        }

        .config-container form select,
        .config-container form input[type="checkbox"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        .button {
            background-color: var(--secondary-color);
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: var(--hover-color);
        }
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Banco de Semillas</h2>
        <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
        @endif
        @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
        @endif  
        <a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Configuración</a>
    </div>
<!-- Desactivación de Cuenta -->
<div class="config-container">
    <h2>Desactivar Cuenta</h2>
    <p>Si deseas desactivar tu cuenta, puedes hacerlo aquí. Ten en cuenta que esta acción es irreversible.</p>
    <form action="{{ route('settings.deactivate') }}" method="POST">
        @csrf
        <button type="submit" class="button" style="background-color: red;">Desactivar Cuenta</button>
    </form>
</div>
</body>
</html>
