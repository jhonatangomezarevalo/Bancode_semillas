
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Panel de Administración</title>
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
            width: calc(100% - 220px);  /* Asegura que el contenido ocupe todo el espacio disponible */
            overflow-y: auto;           /* Permite el desplazamiento si hay contenido que excede la altura */
            max-height: 90vh;           /* Ajuste a la altura disponible para evitar corte */
            position: relative;            /* Asegura que los elementos dentro tengan un posicionamiento adecuado */
        }

        .topbar {
            background: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .config-container {
            overflow: hidden;           /* Evita el desbordamiento de contenido */
            margin-top: 20px;
            text-align: center;
            padding: 10px;
        }

        .config-container h2,
        .config-container p {
            text-align: center;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 300px;
            margin: 0 auto;
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

        /* Ajustes para los canvas */
        canvas {
            max-width: 100% !important;  /* Ocupa el 100% del ancho disponible */
            height: 400px !important;    /* Ajusta la altura para evitar que se recorte */
            margin: 20px auto;           /* Márgenes para separarlo del resto del contenido */
            display: block;
            border-radius: 8px;          /* Bordes redondeados para mejorar la estética */
            position: relative;
        }



    </style>
</head>
<body>

<div class="container">
    <!-- Barra lateral -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.report') }}"><i class="fas fa-chart-line"></i> Reportes</a>
        <a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a>
        <a href="{{ route('admin.semillas') }}"><i class="fas fa-seedling"></i> Semillas</a>
        <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="topbar">
            <h1>Panel de Administración - Banco de Semillas</h1>
        </div>

        <div class="config-container">
            <h2>Reportes</h2>
            <p>Resumen de estadísticas y datos de usuarios y semillas.</p>
        </div>

        <!-- Gráfica de Usuarios por Municipio -->
        <div class="config-container">
            <h3>Usuarios por Municipio</h3>
            <canvas id="usuariosPorMunicipioChart"></canvas>
            <p>{{ $analisisUsuariosPorMunicipio }}</p> <!-- Mostrar análisis dinámico -->
        </div>

        <!-- Gráfica de Semillas por Tipo -->
        <div class="config-container">
            <h3>Semillas por Tipo</h3>
            <canvas id="semillasPorTipoChart"></canvas>
            <p>{{ $analisisSemillasPorTipo }}</p> <!-- Mostrar análisis dinámico -->
        </div>

        <!-- Gráfica de Usuarios por Rol -->
        <div class="config-container">
            <h3>Usuarios por Rol</h3>
            <canvas id="usuariosPorRolChart"></canvas>
            <p>{{ $analisisUsuariosPorRol }}</p> <!-- Mostrar análisis dinámico -->
        </div>
        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Datos para la gráfica de Usuarios por Municipio
    const usuariosPorMunicipioLabels = {!! json_encode($usuariosPorMunicipio->pluck('municipio')->toArray()) !!};
    const usuariosPorMunicipioData = {!! json_encode($usuariosPorMunicipio->pluck('total')->toArray()) !!};

    if (usuariosPorMunicipioLabels.length > 0 && usuariosPorMunicipioData.length > 0) {
        new Chart(document.getElementById('usuariosPorMunicipioChart'), {
            type: 'bar',
            data: {
                labels: usuariosPorMunicipioLabels,
                datasets: [{
                    label: 'Usuarios por Municipio',
                    data: usuariosPorMunicipioData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    } else {
        document.getElementById('usuariosPorMunicipioChart').innerHTML = 'No hay datos disponibles.';
    }

    // Datos para la gráfica de Semillas por Tipo
    const semillasPorTipoLabels = {!! json_encode($semillasPorTipo->pluck('type')->toArray()) !!};
    const semillasPorTipoData = {!! json_encode($semillasPorTipo->pluck('total')->toArray()) !!};

    if (semillasPorTipoLabels.length > 0 && semillasPorTipoData.length > 0) {
        new Chart(document.getElementById('semillasPorTipoChart'), {
            type: 'pie',
            data: {
                labels: semillasPorTipoLabels,
                datasets: [{
                    label: 'Semillas por Tipo',
                    data: semillasPorTipoData,
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    } else {
        document.getElementById('semillasPorTipoChart').innerHTML = 'No hay datos disponibles.';
    }

    // Datos para la gráfica de Usuarios por Rol
    const usuariosPorRolLabels = {!! json_encode($usuariosPorRol->pluck('role_id')->toArray()) !!};
    const usuariosPorRolData = {!! json_encode($usuariosPorRol->pluck('total')->toArray()) !!};

    if (usuariosPorRolLabels.length > 0 && usuariosPorRolData.length > 0) {
        new Chart(document.getElementById('usuariosPorRolChart'), {
            type: 'bar',
            data: {
                labels: usuariosPorRolLabels,
                datasets: [{
                    label: 'Usuarios por Rol',
                    data: usuariosPorRolData,
                    backgroundColor: ['rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    } else {
        document.getElementById('usuariosPorRolChart').innerHTML = 'No hay datos disponibles.';
    }
</script>
</body>
</html>
