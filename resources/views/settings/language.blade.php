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

        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            height: 100vh;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .sidebar {
            width: 200px;
            background: var(--primary-color);
            padding: 20px 10px; /* Reducir padding para evitar el desbordamiento */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: white;
            overflow-y: auto; /* Permite el desplazamiento si el contenido se desborda */
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
            width: 100%; /* Asegurarse de que los enlaces ocupen todo el ancho disponible */
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
            padding: 20px;
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
            max-width: 100%;
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
            width: 100%;
            max-width: 400px; /* Limitar el ancho de los inputs */
        }

        .button {
            background: var(--secondary-color);
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            width: 100%;
            max-width: 200px; /* Limitar el ancho del botón */
        }

        .button:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
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

<div class="main-content">
    <div class="config-container">
        <h2>Idiomas y Configuración Regional</h2>
        <p>Selecciona el idioma y el formato de fecha y hora que prefieras para la aplicación.</p>
        <form action="{{ route('settings.language.update') }}" method="POST">
            @csrf
            <div>
                <label for="language">Idioma:</label>
                <select name="language">
                    <option value="es">Español</option>
                    <option value="en">Inglés</option>
                    <option value="fr">Francés</option>
                </select>
            </div>
            <div>
                <label for="date_format">Formato de Fecha:</label>
                <select name="date_format">
                    <option value="dd-mm-yyyy">DD-MM-YYYY</option>
                    <option value="mm-dd-yyyy">MM-DD-YYYY</option>
                </select>
            </div>
            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</div>
</body>
</html>
