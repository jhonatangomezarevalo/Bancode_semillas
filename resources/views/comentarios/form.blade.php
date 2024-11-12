@auth
    <form action="{{ route('comentarios.store', $semilla->id) }}" method="POST">
        @csrf
        <label for="comentario">Comentario</label>
        <textarea name="comentario" id="comentario" required></textarea>
        <button type="submit">Añadir Comentario</button>
    </form>
@endauth
