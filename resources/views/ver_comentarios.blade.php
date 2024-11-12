<!DOCTYPE html>
<html>
<head>
    <title>Comentarios</title>
</head>
<body>
    <h1>Comentarios</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Comentario</th>
            <th>Semilla ID</th>
            <th>Usuario ID</th>
            <th>Fecha de Creación</th>
        </tr>
        @foreach($comentarios as $comentario)
            <tr>
                <td>{{ $comentario->id }}</td>
                <td>{{ $comentario->comentario }}</td>
                <td>{{ $comentario->semilla_id }}</td>
                <td>{{ $comentario->user_id }}</td>
                <td>{{ $comentario->created_at }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
