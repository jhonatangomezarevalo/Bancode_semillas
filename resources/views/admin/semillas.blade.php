<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Gestión de Semillas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .filter-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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

        .filter-container button {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .filter-container button:hover {
            background-color: var(--secondary-color);
        }

        .analysis-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .analysis-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .analysis-container table th, .analysis-container table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .analysis-container table th {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-delete {
            background-color: #ff4d4d;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-delete:hover {
            background-color: #cc0000;
        }

        .btn-view {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-view:hover {
            background-color: #218838;
        }

        /* Estilos para las gráficas */
        .chart-container {
            position: relative;
            height: 300px;
            width: 45%;
            margin-top: 20px;
            display: inline-block;
            margin-right: 10%;
        }

        .charts-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>Banco de Semillas</h2>
        <a href="{{ route('admin.index') }}"><i class="fas fa-home"></i>Inicio</a>
        <a href="{{ route('admin.report') }}"><i class="fas fa-chart-line"></i> Reportes</a>
        <a href="{{ route('admin.usuarios') }}"><i class="fas fa-users"></i> Usuarios</a>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h1>Gestión de Semillas</h1>
        </div>

        <div class="filter-container">
            <form action="{{ route('admin.semillas') }}" method="GET">
                <label for="nombre">Buscar semilla:</label>
                <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Nombre de la semilla">

                <label for="municipio">Municipio:</label>
                <select name="municipio">
                    <option value="">Seleccione municipio</option>
                    @foreach($municipios as $municipio)
                        <option value="{{ $municipio }}" {{ request('municipio') == $municipio ? 'selected' : '' }}>{{ $municipio }}</option>
                    @endforeach
                </select>

                <label for="disponible">Disponibilidad:</label>
                <select name="disponible">
                    <option value="">Seleccione disponibilidad</option>
                    <option value="Sí" {{ request('disponible') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    <option value="No" {{ request('disponible') == 'No' ? 'selected' : '' }}>No</option>
                </select>

                <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="charts-wrapper">
        <!-- Contenedor para la gráfica de tipo de semillas -->
            <div class="chart-container">
                <canvas id="chart1"></canvas>
                <div id="chart1-analysis" class="chart-analysis"></div> <!-- Contenedor para el análisis de la gráfica 1 -->
            </div>

            <!-- Contenedor para la gráfica de disponibilidad de semillas -->
            <div class="chart-container">
                <canvas id="chart2"></canvas>
                <div id="chart2-analysis" class="chart-analysis"></div> <!-- Contenedor para el análisis de la gráfica 2 -->
            </div>
        </div>

        <div class="analysis-container">
            <h3>Semillas Disponibles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Nombre de Semilla</th>
                        <th>Tipo de Semilla</th> 
                        <th>Municipio</th>
                        <th>Información Base</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semillas as $semilla)
                        <tr>
                            <td>{{ $semilla->usuario_nombre }}</td>
                            <td>{{ $semilla->nombre_semilla }}</td>
                            <td>{{ $semilla->type }}</td> 
                            <td>{{ $semilla->municipio }}</td>
                            <td>{{ $semilla->base_info }}</td>
                            <td>{{ $semilla->disponible }}</td>
                            <td>
                                <a href="{{ route('feed.search', $semilla->inventario_id) }}" class="btn-view">Ver</a>
                                <form action="{{ route('admin.semillas.destroy', $semilla->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


<script>
    // Variables con datos recibidos de PHP
    var labels = @json($labels);
    var countsPorTipo = @json($countsPorTipo);
    var disponibilidadCounts = @json($disponibilidadCounts);

    // Gráfica de tipo de semillas
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,  // Tipos de semilla
            datasets: [{
                label: 'Cantidad de Semillas por Tipo',
                data: Object.values(countsPorTipo),  // Datos (conteos por tipo)
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

    // Análisis para la gráfica de tipo de semillas
    var maxTipo = labels[Object.values(countsPorTipo).indexOf(Math.max(...Object.values(countsPorTipo)))];
    var minTipo = labels[Object.values(countsPorTipo).indexOf(Math.min(...Object.values(countsPorTipo)))];
    var totalSemillas = Object.values(countsPorTipo).reduce((a, b) => a + b, 0);
    var chart1AnalysisText = `El tipo de semilla más común es "${maxTipo}" y el menos común es "${minTipo}". Total de semillas: ${totalSemillas}.`;

    document.getElementById('chart1-analysis').innerText = chart1AnalysisText;

    // Gráfica de disponibilidad de semillas
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: Object.keys(disponibilidadCounts),  // Disponibilidad (Sí/No)
            datasets: [{
                label: 'Disponibilidad de Semillas',
                data: Object.values(disponibilidadCounts),  // Cantidades de disponibilidad
                backgroundColor: ['#FF5733', '#33FF57'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Análisis para la gráfica de disponibilidad de semillas
    var disponibles = disponibilidadCounts['Sí'] || 0;
    var noDisponibles = disponibilidadCounts['No'] || 0;
    var porcentajeDisponibles = ((disponibles / (disponibles + noDisponibles)) * 100).toFixed(2);
    var chart2AnalysisText = `Del total de semillas, el ${porcentajeDisponibles}% está disponible, mientras que el ${(100 - porcentajeDisponibles).toFixed(2)}% no está disponible.`;

    document.getElementById('chart2-analysis').innerText = chart2AnalysisText;
</script>


</body>
</html>
