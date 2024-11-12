<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Banco de Semillas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos generales */
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #777;
            --hover-color: #004d26;
            --border-color: #ddd;
            --sidebar-width: 180px;
            --content-max-width: 1000px; /* Ajusté este valor para mayor flexibilidad */
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 16px;
            color: var(--text-color);
            background-color: #f9f9f9;
        }

        input:focus, select:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: var(--hover-color);
        }

        .campo-rol {
            display: none;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registro de Usuario</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="role">Rol:</label>
            <select name="role" id="role" required>
                <option value="Agricultor" {{ old('role') == 'Agricultor' ? 'selected' : '' }}>Agricultor</option>
                <option value="Custodio" {{ old('role') == 'Custodio' ? 'selected' : '' }}>Custodio</option>
                <option value="Casa de Semillas" {{ old('role') == 'Casa de Semillas' ? 'selected' : '' }}>Casa de Semillas</option>
                <option value="Docente Académico" {{ old('role') == 'Docente Académico' ? 'selected' : '' }}>Docente Académico</option>
                <option value="Estudiante" {{ old('role') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
            </select>
        </div>

        <!-- Campos comunes para todos los roles -->
        <div class="form-group">
            <label for="ubicacion">Ubicación:</label>
            <input type="text" name="ubicacion" id="ubicacion" required value="{{ old('ubicacion') }}">
        </div>

        <div class="form-group">
            <label for="municipio">Municipio:</label>
            <input type="text" name="municipio" id="municipio" required value="{{ old('municipio') }}">
        </div>

        <!-- Campos específicos para cada rol -->
        <div id="campo_nombre_finca" class="campo-rol">
            <div class="form-group">
                <label for="nombre_finca">Nombre de la Finca:</label>
                <input type="text" name="nombre_finca" id="nombre_finca" value="{{ old('nombre_finca') }}">
            </div>
        </div>

        <div id="campo_nombre_custodio" class="campo-rol">
            <div class="form-group">
                <label for="nombre_custodio">Nombre del Custodio:</label>
                <input type="text" name="nombre_custodio" id="nombre_custodio" value="{{ old('nombre_custodio') }}">
            </div>
        </div>

        <div id="campo_nombre_casa_semillas" class="campo-rol">
            <div class="form-group">
                <label for="nombre_casa_semillas">Nombre de la Casa de Semillas:</label>
                <input type="text" name="nombre_casa_semillas" id="nombre_casa_semillas" value="{{ old('nombre_casa_semillas') }}">
            </div>
        </div>

        <div id="campo_institucion_educativa" class="campo-rol">
            <div class="form-group">
                <label for="institucion_educativa">Institución Educativa:</label>
                <input type="text" name="institucion_educativa" id="institucion_educativa" value="{{ old('institucion_educativa') }}">
            </div>
        </div>

        <button type="submit">Registrar</button>
    </form>

    <div class="form-footer">
        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        var selectedRole = this.value;

        // Ocultar todos los campos de rol
        document.querySelectorAll('.campo-rol').forEach(function(field) {
            field.style.display = 'none';
        });

        // Mostrar el campo correspondiente según el rol
        if (selectedRole == 'Agricultor') {
            document.getElementById('campo_nombre_finca').style.display = 'block';
        } else if (selectedRole == 'Custodio') {
            document.getElementById('campo_nombre_custodio').style.display = 'block';
        } else if (selectedRole == 'Casa de Semillas') {
            document.getElementById('campo_nombre_casa_semillas').style.display = 'block';
        } else if (selectedRole == 'Docente Académico' || selectedRole == 'Estudiante') {
            document.getElementById('campo_institucion_educativa').style.display = 'block';
        }
    });

    // Inicializar la visibilidad de los campos dependiendo del rol seleccionado inicialmente
    document.getElementById('role').dispatchEvent(new Event('change'));
</script>

</body>
</html>
