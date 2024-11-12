<!-- resources/views/feed.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas UdeC - Feed</title>
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
            background-color: var(--background-color);
            color: var(--text-color);
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-color);
            padding: 10px 20px;
            color: white;
        }
        .navbar .logo {
            font-size: 18px;
            font-weight: 600;
        }
        .navbar .search-bar {
            display: flex;
            align-items: center;
            position: relative;
        }
        .navbar .search-bar input {
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            outline: none;
            width: 0;
            transition: width 0.4s ease-in-out;
            opacity: 0;
        }
        .navbar .search-bar input:focus {
            width: 250px;
            opacity: 1;
        }
        .navbar .search-bar .fas {
            margin-left: 10px;
            cursor: pointer;
        }
        .navbar .icons {
            display: flex;
            align-items: center;
        }
        .navbar .icons i {
            margin-left: 15px;
            cursor: pointer;
        }
        .sidebar {
            position: fixed;
            top: 50px;
            left: 0;
            width: 200px;
            background-color: #fff;
            border-right: 1px solid #ddd;
            height: 100%;
            padding: 20px;
        }
        .sidebar a {
            display: block;
            margin-bottom: 20px;
            color: var(--text-color);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
        }
        .sidebar a:hover {
            color: var(--primary-color);
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            margin-top: 50px;
        }
        .post-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .post-card h2 {
            margin: 0;
            font-size: 20px;
            color: var(--primary-color);
        }
        .post-card p {
            margin-top: 10px;
            font-size: 16px;
            color: var(--text-color);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">Banco de Semillas UdeC</div>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Buscar semillas o usuarios...">
        </div>
        <div class="icons">
            <i class="fas fa-envelope"></i>
            <i class="fas fa-bell"></i>
            <i class="fas fa-user-friends"></i>
            <i class="fas fa-cog"></i>
        </div>
    </div>

    <div class="sidebar">
        <a href="{{ route('profile') }}">Perfil</a>
        <a href="{{ route('feed.index') }}">Feed</a>
        <!-- Puedes agregar más enlaces aquí según sea necesario -->
    </div>

    <div class="content">
        @foreach($posts as $post)
            <div class="post-card">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <!-- Aquí puedes añadir más detalles de la publicación si es necesario -->
            </div>
        @endforeach
    </div>
</body>
</html>
