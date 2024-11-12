<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Semillas - Gestión de Usuarios</title>
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
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.index') }}"><i class="fas fa-home"></i>Inicio</a>
        <a href="{{ route('admin.report') }}"><i class="fas fa-chart-line"></i> Reportes</a>
        <a href="{{ route('admin.semillas') }}"><i class="fas fa-seedling"></i> Semillas</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h2>Gestión de Usuarios</h2>
        </div>

        <!-- Filter Form -->
        <div class="filter-container">
            <h3>Filtrar Usuarios</h3>
            <form method="GET" action="{{ route('admin.usuarios') }}">
                <label for="role">Seleccionar Rol:</label>
                <select id="role" name="role">
                    <option value="">-- Todos --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>

                <label for="municipio">Seleccionar Municipio:</label>
                <select id="municipio" name="municipio">
                    <option value="">-- Todos --</option>
                    @foreach($municipios as $municipio)
                        <option value="{{ $municipio }}" {{ request('municipio') == $municipio ? 'selected' : '' }}>
                            {{ ucfirst($municipio) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">Filtrar</button>
            </form>
        </div>

        <div class="analysis-container">
            <h3>Lista de Usuarios</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Municipio</th> <!-- Agregamos columna de Municipio -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->role->name }}</td>
                            <td>{{ $usuario->municipio }}</td>
                            <td>
                                <a href="{{ route('profile.show_user', $usuario->id) }}" class="btn-view">Ver</a>
                                <a href="{{ route('admin.usuarios.eliminar', $usuario->id) }}" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
        </div>

        <div>
          <!-- Gráficas de Análisis -->
        <div class="analysis-container">
            <h3>Análisis de Usuarios</h3>
            <div style="display: flex; justify-content: space-between; gap: 20px;">
                <div style="flex: 1;">
                    <h4>Distribución de Roles</h4>
                    <div class="chart-container">
                        <canvas id="rolesChart"></canvas>
                    </div>
                    <div id="rolesAnalysis" style="margin-top: 10px;"></div>
                </div>

                <div style="flex: 1;">
                    <h4>Distribución de Municipios</h4>
                    <div class="chart-container">
                        <canvas id="municipiosChart"></canvas>
                    </div>
                    <div id="municipiosAnalysis" style="margin-top: 10px;"></div>
                </div>
            </div>
        </div>

        </div>
        </div>
    </div>
</div>

<script>
    // Datos de las gráficas
    var rolesData = @json($roleCounts);
    var municipiosData = @json($municipioCounts);
    
    var rolesChart = new Chart(document.getElementById('rolesChart'), {
        type: 'pie',
        data: {
            labels: @json($roles->pluck('name')), // Usar los nombres de los roles
            datasets: [{
                label: 'Distribución por Rol',
                data: rolesData,
                backgroundColor: ['#FF6347', '#4CAF50', '#FFD700', '#00BFFF'],
                hoverOffset: 4
            }]
        }
    });

    var municipiosChart = new Chart(document.getElementById('municipiosChart'), {
        type: 'pie',
        data: {
            labels: @json($municipios), // Usar los municipios
            datasets: [{
                label: 'Distribución por Municipio',
                data: municipiosData,
                backgroundColor: ['#FF6347', '#4CAF50', '#FFD700', '#00BFFF'],
                hoverOffset: 4
            }]
        }
    });

    // Análisis de la Distribución de Roles
    var totalRoles = rolesData.reduce(function(sum, count) {
        return sum + count;
    }, 0);

    var rolesAnalysis = rolesData.map(function(count, index) {
        var percentage = ((count / totalRoles) * 100).toFixed(2);
        return {
            role: @json($roles)[index].name,
            count: count,
            percentage: percentage
        };
    });

    // Mostrar el análisis de roles
    var rolesAnalysisElement = document.getElementById('rolesAnalysis');
    rolesAnalysisElement.innerHTML = rolesAnalysis.map(function(data) {
        return `
            <div>
                <strong>${data.role}:</strong> ${data.count} usuarios (${data.percentage}%)
            </div>
        `;
    }).join('');

    // Análisis de la Distribución de Municipios
    var totalMunicipios = municipiosData.reduce(function(sum, count) {
        return sum + count;
    }, 0);

    var municipiosAnalysis = municipiosData.map(function(count, index) {
        var percentage = ((count / totalMunicipios) * 100).toFixed(2);
        return {
            municipio: @json($municipios)[index],
            count: count,
            percentage: percentage
        };
    });

    // Mostrar el análisis de municipios
    var municipiosAnalysisElement = document.getElementById('municipiosAnalysis');
    municipiosAnalysisElement.innerHTML = municipiosAnalysis.map(function(data) {
        return `
            <div>
                <strong>${data.municipio}:</strong> ${data.count} usuarios (${data.percentage}%)
            </div>
        `;
    }).join('');
</script>


</body>
</html>
