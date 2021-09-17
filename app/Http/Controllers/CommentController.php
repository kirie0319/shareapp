<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $item = Comment::create($request->all());
        $user = User::find($item->user_id)->first();
        $item->user_name = $user->name;
        return response()->json([
            'data' => $item
        ], 201);
    }
    public function show(Request $request)
    {
        $post = Post::with("comments")->find($request->post_id);
        $post_user = User::find($post->user_id)->first();
        $post->user_name = $post_user->name;
        foreach ($post->comments as $comment) {
            $comment_user = User::find($comment->user_id)->first();
            $comment->user_name = $comment_user->name;
        }
        if ($post) {
            return response()->json([
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }
    }
}
