<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Mostrar todos los comentarios
     */
    public function index()
    {
        return response()->json(
            Comment::with('user', 'post')->get()
        );
    }

    /**
     * Crear comentario
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string'
        ]);

        $comment = Comment::create($fields);

        return response()->json($comment, 201);
    }

    /**
     * Mostrar comentario específico
     */
    public function show(Comment $comment)
    {
        return response()->json(
            $comment->load('user', 'post')
        );
    }

    /**
     * Actualizar comentario
     */
    public function update(Request $request, Comment $comment)
    {
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string'
        ]);

        $comment->update($fields);

        return response()->json($comment);
    }

    /**
     * Eliminar comentario
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'message' => 'Comentario eliminado correctamente'
        ]);
    }
}
