<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function index(int $postId)
    {
        $post = Post::findOrFail($postId);

        return response()->json(
            $post->comments()->latest()->get(),
            200
        );
    }

    public function store(Request $request, int $postId)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'author' => Str::substr($request->user()->name, 0, 100),
            'content' => $data['content'],
        ]);

        return response()->json($comment, 201);
    }
}
