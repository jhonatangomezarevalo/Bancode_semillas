<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Reporte</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <style>
        /* Estilos personalizados */
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
            height: 100%;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .sidebar {
            width: 200px;
            background: var(--primary-color);
            padding: 20px 10px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            color: white;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin-bottom: 15px;
            font-size: 16px;
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            color: var(--accent-color);
            background-color: var(--hover-color);
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
            margin-bottom: 20px;
        }

        .analysis-container, .filter-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        canvas {
            max-width: 100%;
            height: 400px;
            margin: 20px auto;
            display: block;
            border-radius: 8px;
        }

        .filter-container label, .filter-container select {
            margin-right: 10px;
            font-size: 16px;
        }

        .filter-container select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .analysis-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .analysis-box h3 {
            margin-top: 0;
            color: var(--primary-color);
        }
        .analysis-box p {
            font-size: 16px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="sidebar">
            <h2>Banco de Semillas</h2>
            <a href="{{ route('admin.index') }}"><i class="fas fa-home"></i>Inicio</a>
            <a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a>
            <a href="{{ route('admin.semillas') }}"><i class="fas fa-seedling"></i> Semillas</a>
        </div>

        <div class="main-content">
            <div class="topbar">
                <h1>Reporte de Registros</h1>
            </div>

            <div class="analysis-container">
                <div class="filter-container">
                    <form method="GET" action="{{ route('admin.report') }}">
                        <label for="filter">Periodo de tiempo:</label>
                        <select name="filter" id="filter" onchange="this.form.submit()">
                            <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Día</option>
                        </select>
                    </form>
                </div>

                <canvas id="userRegistrationChart"></canvas>

                <div id="analysis-box" class="analysis-box">
                    <h3>Análisis de Registros</h3>
                    <p id="total-registrations">Total de Registros: </p>
                    <p id="average-registrations">Promedio de Registros: </p>
                    <p id="max-registrations">Máximo de Registros en un Período: </p>
                    <p id="min-registrations">Mínimo de Registros en un Período: </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables para almacenar datos de registros y etiquetas
        const registrationData = JSON.parse(`@json($userRegistrations->pluck('label'))`);
        const registrationLabels = JSON.parse(`@json($userRegistrations->pluck('count'))`);

        // Verificamos si tenemos datos para mostrar
        if (registrationData.length > 0 && registrationLabels.length > 0) {
            // Generamos la gráfica de registros
            const ctx = document.getElementById('userRegistrationChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: registrationLabels,
                    datasets: [{
                        label: 'Registros de Usuarios',
                        data: registrationLabels,
                        backgroundColor: 'rgba(0, 102, 51, 0.7)',
                        borderColor: 'rgba(0, 102, 51, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } else {
            document.getElementById('userRegistrationChart').style.display = 'none';
            document.getElementById('analysis-box').innerHTML += '<p>No hay datos suficientes para mostrar la gráfica.</p>';
        }

        // Cálculo de análisis
        const totalRegistrations = d3.sum(registrationLabels);
        const averageRegistrations = d3.mean(registrationLabels).toFixed(2);
        const maxRegistrations = d3.max(registrationLabels);
        const minRegistrations = d3.min(registrationLabels);

        // Mostramos el análisis
        document.getElementById('total-registrations').textContent = `Total de Registros: ${totalRegistrations}`;
        document.getElementById('average-registrations').textContent = `Promedio de Registros: ${averageRegistrations}`;
        document.getElementById('max-registrations').textContent = `Máximo de Registros en un Período: ${maxRegistrations}`;
        document.getElementById('min-registrations').textContent = `Mínimo de Registros en un Período: ${minRegistrations}`;
    </script>
</body>
</html>
