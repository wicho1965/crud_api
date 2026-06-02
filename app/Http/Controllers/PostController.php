<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Mostrar todos los posts
     */
    public function index()
    {
        return response()->json(
            Post::with('user', 'comments')->get()
        );
    }

    /**
     * Crear un nuevo post
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = Post::create($fields);

        return response()->json($post, 201);
    }

    /**
     * Mostrar un post específico
     */
    public function show(Post $post)
    {
        return response()->json(
            $post->load('user', 'comments')
        );
    }

    /**
     * Actualizar un post
     */
    public function update(Request $request, Post $post)
    {
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post->update($fields);

        return response()->json($post);
    }

    /**
     * Eliminar un post
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post eliminado correctamente'
        ]);
    }
}
