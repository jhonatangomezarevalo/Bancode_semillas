<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Semilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8f0;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-group input[type="file"] {
            padding: 0;
        }
        .form-group button {
            background-color: #006633;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #004d26;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Semilla</h1>
        <form action="{{ route('seeds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nombre de la Semilla</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="image">Imagen de la Semilla</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="visibility">Visible</label>
                <input type="checkbox" name="visibility" id="visibility" checked>
            </div>
            <div class="form-group">
                <button type="submit">Agregar Semilla</button>
            </div>
        </form>
    </div>
</body>
</html>
