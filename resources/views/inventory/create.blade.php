<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Semilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #006633;
            --secondary-color: #009933;
            --accent-color: #FFCC00;
            --background-color: #f0f8f0;
            --text-color: #333;
            --light-text-color: #555;
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
    margin-left: 200px; /* Espacio para la barra lateral */
    padding: 20px;
    width: calc(100% - 200px); /* Resta el ancho de la barra lateral */
    background: white;
    box-sizing: border-box; /* Incluye padding en el cálculo del tamaño total */
    min-height: 100vh; /* Asegura que el contenido ocupe toda la altura de la ventana */
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto; /* Permite el desplazamiento vertical si el contenido es más largo que la pantalla */
}

.main-content h1 {
    font-size: 28px;
    margin-bottom: 30px;
    color: var(--primary-color);
    text-align: center;
    width: 100%;
}

form {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: white;
}

label {
    font-size: 18px;
    margin-bottom: 8px;
    color: var(--primary-color);
    font-weight: 600;
}

input[type="text"], textarea, input[type="file"] {
    padding: 12px;
    font-size: 16px;
    margin-bottom: 20px;
    border: 1px solid var(--input-border-color);
    border-radius: 8px;
    width: 100%;
    box-sizing: border-box;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus, textarea:focus, input[type="file"]:focus {
    border-color: var(--input-focus-border-color);
    box-shadow: 0 0 8px rgba(0, 153, 51, 0.2);
    outline: none;
}

textarea {
    min-height: 150px;
    resize: vertical;
}

button[type="submit"] {
    padding: 12px 20px;
    font-size: 18px;
    color: white;
    background-color: var(--secondary-color);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    align-self: flex-end;
}

button[type="submit"]:hover {
    background-color: var(--primary-color);
    transform: translateY(-2px);
}

.example-text {
    font-size: 14px;
    color: var(--light-text-color);
    margin-top: -15px;
    margin-bottom: 15px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Banco de Semillas</h2>
            <a href="{{ route('feed.index') }}"><i class="fas fa-home"></i> Inicio</a>
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas')
            <a href="{{ route('inventory.index') }}"><i class="fas fa-seedling"></i> Inventario</a>
            @endif
            @if (auth()->user()->role->name == 'Agricultor' || auth()->user()->role->name == 'Custodio' || auth()->user()->role->name == 'Casa de Semillas')
            <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i> Mensajes</a>
            @endif  
            <a href="#"><i class="fas fa-cog"></i> Configuración</a>
        </div>

        <div class="main-content">
            <h1>Agregar Nueva Semilla</h1>
            <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="name">Nombre de la Semilla:</label>
                <input type="text" id="name" name="name" required>

                <label for="type">Tipo de Semilla:</label>
                <input type="text" id="type" name="type" required>

                <label for="base_info">Información Base:</label>
                <textarea id="base_info" name="base_info" placeholder="Ejemplo: 
- Distancia de Siembra: 20 cm
- Profundidad de Siembra: 5 cm
- Características: Se adapta a alturas de 0 a 2000 metros sobre el nivel del mar. Temperatura ideal: 20-25°C.
- Descripción: Esta semilla es ideal para climas templados, fácil de cultivar."></textarea>

                <label for="adaptable_info">Información Adaptable:</label>
                <textarea id="adaptable_info" name="adaptable_info" placeholder="Ejemplo: 
- Usos Gastronómicos: Utilizado en ensaladas, sopas y guisos.
- Usos Medicinales: Infusión utilizada para aliviar problemas digestivos."></textarea>

                <label for="traceability_info">Información de Trazabilidad:</label>
                <textarea id="traceability_info" name="traceability_info" placeholder="Ejemplo: 
- Características Ambientales: Requiere suelo bien drenado y exposición solar completa.
- Plagas: Propenso a ataques de pulgones.
- Resistencia a Plagas: Moderada resistencia a pulgones.
- Cuidados: Requiere riego regular, especialmente en épocas secas."></textarea>

                <label for="image">Imagen:</label>
                <input type="file" id="image" name="image">

                <label for="disponible">Disponible:</label>
                    <select name="disponible" id="disponible">
                        <option value="Sí" {{ old('disponible', 'Sí') == 'Sí' ? 'selected' : '' }}>Sí</option>
                        <option value="No" {{ old('disponible', 'Sí') == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</body>
</html>