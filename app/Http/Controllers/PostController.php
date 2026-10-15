<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Listar publicaciones.
     *
     * Obtiene las publicaciones con sus imágenes y comentarios.
     * Permite buscar por título o contenido y pagina los resultados
     * de 10 en 10.
     *
     * @queryParam search string Filtrar por título o contenido. Example: viaje
     * @queryParam page integer Número de página. Example: 1
     */
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $posts = Post::with(['images', 'comments'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $posts->getCollection()->transform(function ($post) {
            $post->images->transform(function ($img) {
                $img->image_url = asset('storage/' . $img->image_path);

                return $img;
            });

            return $post;
        });

        return response()->json($posts, 200);
    }

    /**
     * Consultar una publicación.
     *
     * Obtiene una publicación específica con sus imágenes
     * y comentarios.
     *
     * @urlParam id integer required ID de la publicación. Example: 1
     */
    public function show(int $id)
    {
        $post = Post::with(['images', 'comments'])->findOrFail($id);

        $post->images->transform(function ($img) {
            $img->image_url = asset('storage/' . $img->image_path);

            return $img;
        });

        return response()->json($post, 200);
    }

    /**
     * Crear una publicación.
     *
     * Permite crear una publicación con título, contenido
     * y múltiples imágenes.
     * La publicación queda asociada al usuario autenticado.
     *
     * @authenticated
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');

                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return response()->json($post->load('images'), 201);
    }

    /**
     * Dar like a una publicación.
     *
     * Permite que un usuario autenticado dé un único like
     * a cada publicación.
     * Si ya registró un like, devuelve un error 409.
     *
     * @authenticated
     * @urlParam id integer required ID de la publicación. Example: 1
     */
    public function like(Request $request, int $id)
    {
        $post = Post::findOrFail($id);

        $userId = $request->user()->id;

        if ($post->likedBy()->where('users.id', $userId)->exists()) {
            return response()->json([
                'message' => 'Ya diste like a esta publicación',
                'likes_count' => $post->likedBy()->count(),
            ], 409);
        }

        $post->likedBy()->attach($userId);

        $likesCount = $post->likedBy()->count();

        $post->update([
            'likes_count' => $likesCount,
        ]);

        return response()->json([
            'message' => 'Me gusta añadido correctamente',
            'likes_count' => $likesCount,
        ], 200);
    }

    /**
     * Eliminar una publicación.
     *
     * Permite eliminar una publicación únicamente cuando
     * pertenece al usuario autenticado.
     * También elimina las imágenes almacenadas.
     * Si el usuario no es el propietario, devuelve un error 403.
     *
     * @authenticated
     * @urlParam id integer required ID de la publicación. Example: 1
     */
    public function destroy(Request $request, int $id)
    {
        $post = Post::with('images')->findOrFail($id);

        if ((int) $post->user_id !== (int) $request->user()->id) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar esta publicación',
            ], 403);
        }

        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
