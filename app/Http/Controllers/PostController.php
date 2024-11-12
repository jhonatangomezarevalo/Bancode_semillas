<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Muestra una lista de todas las publicaciones
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // Acepta una publicación, haciéndola visible
    public function accept($id)
    {
        $post = Post::findOrFail($id);
        $post->is_visible = true;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Publicación aceptada.');
    }

    // Rechaza una publicación, haciéndola no visible
    public function reject($id)
    {
        $post = Post::findOrFail($id);
        $post->is_visible = false;
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Publicación rechazada.');
    }

    // Elimina una publicación
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Publicación eliminada.');
    }
}
