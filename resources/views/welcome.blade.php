<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas UdeC - Inicio</title>
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
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .welcome-card::before {
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
        .logo {
            width: 180px; /* Aumenta el tamaño aquí */
            margin-bottom: 20px;
        }
        h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
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
            margin-top: 10px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .links {
            margin-top: 20px;
        }
        .links a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        .links a:hover {
            color: var(--secondary-color);
        }
        .udec-info {
            position: absolute;
            bottom: 20px;
            left: 20px;
            text-align: left;
        }
        .udec-info h2 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .udec-info p {
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-card">
            <img src="{{ asset('images/logo.jpeg') }}" alt="UdeC Logo" class="logo">
            <h1>Banco de Semillas UdeC</h1>
            <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn">Registrarse</a>
        </div>
    </div>
    <div class="udec-info">
        <h2>Universidad de Cundinamarca</h2>
        <p>Facultad de Ciencias Agropecuarias</p>
        <p>Preservando la biodiversidad, un grano a la vez.</p>
    </div>
</body>
</html>
