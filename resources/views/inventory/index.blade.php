<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Semillas</title>
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
            margin-left: 200px;
            padding: 20px;
            width: calc(100% - 200px);
            background: white;
            box-sizing: border-box;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            overflow-y: auto;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--primary-color);
            text-align: center;
        }

        .button {
            padding: 8px 16px;
            font-size: 16px;
            color: white;
            background-color: var(--secondary-color);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .seed-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            justify-content: center;
        }

        .seed {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 10px;
            text-align: center;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .seed img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            max-height: 300px;
        }

        .seed .seed-info {
            margin-bottom: 15px;
            text-align: left;
            width: 100%;
        }

        .seed .edit-button,
        .seed .delete-button {
            padding: 8px 12px;
            font-size: 14px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px 0;
        }

        .seed .edit-button {
            background-color: var(--secondary-color);
        }

        .seed .edit-button:hover {
            background-color: var(--primary-color);
        }

        .seed .delete-button {
            background-color: red;
        }

        .seed .delete-button:hover {
            background-color: darkred;
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
    <div class="container">
        <div class="sidebar">
            <h2>Banco de Semillas</h2>
            <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
            <a href="{{ route('profile') }}"><i class="fas fa-user"></i> Perfil</a>
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas' || auth()->user()->role->name == 'Admin')
            <a href="{{ route('inventory.create') }}" class="button">Agregar Semilla</a>
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
            <h1>Inventario de Semillas</h1>
            <a href="{{ route('inventory.create') }}" class="button">Agregar Nueva Semilla</a>

            <div class="seed-container">
                @foreach($inventories as $inventory)
                    <div class="seed">
                        @if($inventory->image_path)
                            <img src="{{ asset('storage/' . $inventory->image_path) }}" alt="{{ $inventory->name }}">
                        @endif
                        <div class="seed-info">
                            <h2>{{ $inventory->name }}</h2>
                            <p><strong>Tipo:</strong> {{ $inventory->type }}</p>
                            <p><strong>Informacion base:</strong> {{ $inventory->base_info }}</p>
                            <p><strong>Informacion de adaptabilidad:</strong> {{ $inventory->adaptable_info }}</p>
                            <p><strong>Informacion de trazabilidad:</strong> {{ $inventory->traceability_info }}</p>
                            <p><strong>Disponible:</strong> {{ $inventory->disponible}}</p>
                        </div>
                        <a href="{{ route('inventory.edit', $inventory->id) }}"class = "button" >Editar</a>
                        <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta semilla?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
