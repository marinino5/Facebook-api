<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['images', 'comments'])
            ->latest()
            ->get()
            ->map(function ($post) {
                $post->images->transform(function ($img) {
                    $img->image_url = asset('storage/' . $img->image_path);
                    return $img;
                });

                return $post;
            });

        return response()->json($posts, 200);
    }

    public function show(int $id)
    {
        $post = Post::with(['images', 'comments'])->findOrFail($id);

        $post->images->transform(function ($img) {
            $img->image_url = asset('storage/' . $img->image_path);
            return $img;
        });

        return response()->json($post, 200);
    }

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

    public function like(int $id)
    {
        $post = Post::findOrFail($id);

        $post->increment('likes_count');

        return response()->json([
            'message' => 'Me gusta añadido correctamente',
            'likes_count' => $post->likes_count,
        ], 200);
    }

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
