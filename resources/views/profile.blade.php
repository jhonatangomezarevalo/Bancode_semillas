<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
        }
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--background-color) 0%, #ffffff 100%);
            height: 100%;
            color: var(--text-color);
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 20px;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
        }
        .profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shine 2s infinite;
        }
        @keyframes shine {
            0% { left: -50%; }
            100% { left: 150%; }
        }
        h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        small {
            display: block;
            margin-top: 5px;
            color: #666;
        }
        .status-message {
            margin-top: 20px;
            color: var(--secondary-color);
            font-weight: 600;
        }
        footer {
            position: absolute;
            bottom: 20px;
            left: 20px;
            text-align: left;
        }
        footer p {
            margin: 0;
            color: var(--text-color);
        }
        .profile-photo {
            margin-bottom: 20px;
        }
        .profile-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-card">
            <h1>Perfil del Usuario</h1>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="profile-photo">
                    @if ($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de perfil">
                    @else
                        <p>No tienes una foto de perfil.</p>
                    @endif
                </div>

                <div>
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div>
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password">
                    <small>Deja en blanco si no deseas cambiar la contraseña.</small>
                </div>

                <div>
                    <label for="photo">Foto de Perfil:</label>
                    <input type="file" id="photo" name="photo">
                </div>

                <button type="submit" class="btn">Actualizar Perfil</button>

                @if(session('status'))
                    <p class="status-message">{{ session('status') }}</p>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
