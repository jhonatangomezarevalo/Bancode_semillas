<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Notificaciones</title>
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
            overflow: hidden; /* Evita el desbordamiento horizontal y vertical */
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
        }
        .topbar {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
        }
        .config-container {
            margin-top: 20px;
        }
        .config-container h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background: #45a049;
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
        <div class="topbar">
            <h2>Notificaciones</h2>
        </div>

        <div class="config-container">
            <h2>Configuración de Notificaciones</h2>
            <form action="{{ route('settings.notifications.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="email_notifications">Notificaciones por Correo Electrónico:</label>
                    <select id="email_notifications" name="email_notifications">
                        <option value="1" {{ auth()->user()->email_notifications ? 'selected' : '' }}>Activadas</option>
                        <option value="0" {{ !auth()->user()->email_notifications ? 'selected' : '' }}>Desactivadas</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sms_notifications">Notificaciones por SMS:</label>
                    <select id="sms_notifications" name="sms_notifications">
                        <option value="1" {{ auth()->user()->sms_notifications ? 'selected' : '' }}>Activadas</option>
                        <option value="0" {{ !auth()->user()->sms_notifications ? 'selected' : '' }}>Desactivadas</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
