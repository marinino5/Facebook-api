<?php

namespace App\Http\Controllers;

use App\Mail\NewCommentMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * Listar comentarios de una publicación.
     *
     * Obtiene todos los comentarios asociados a una
     * publicación, ordenados del más reciente al más antiguo.
     *
     * Esta consulta es pública y no requiere autenticación.
     *
     * @urlParam id integer required ID de la publicación. Example: 1
     */
    public function index(int $postId)
    {
        $post = Post::findOrFail($postId);

        return response()->json(
            $post->comments()->latest()->get(),
            200
        );
    }

    /**
     * Crear un comentario.
     *
     * Permite que un usuario autenticado agregue un
     * comentario a una publicación existente.
     *
     * El sistema identifica automáticamente al usuario
     * mediante Laravel Sanctum y guarda su nombre
     * e identificador en el comentario.
     *
     * Cuando se registra el comentario, Laravel genera
     * una notificación por correo para el propietario
     * de la publicación.
     *
     * @authenticated
     *
     * @urlParam id integer required ID de la publicación. Example: 1
     * @bodyParam content string required Contenido del comentario. Example: Excelente publicación.
     */
    public function store(Request $request, int $postId)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::with('user')->findOrFail($postId);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'author' => Str::substr($request->user()->name, 0, 100),
            'content' => $data['content'],
        ]);

        if ($post->user && $post->user->email) {
            Mail::to($post->user->email)
                ->send(new NewCommentMail($comment));
        }

        return response()->json($comment, 201);
    }
}
