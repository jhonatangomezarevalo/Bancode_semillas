<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Semillas</title>
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
        }
        .seed-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .seed-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 10px;
            transition: box-shadow 0.3s ease;
        }
        .seed-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .seed-card h3 {
            margin: 10px 0;
            color: #006633;
        }
        .seed-card p {
            color: #777;
        }
        .seed-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="seed-grid">
            @foreach($seeds as $seed)
                <div class="seed-card">
                    <img src="{{ asset('storage/' . $seed->image_path) }}" alt="{{ $seed->name }}">
                    <h3>{{ $seed->name }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
