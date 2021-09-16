<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $items = Post::all();
        foreach($items as $item) {
          $user = User::where('id', $item->user_id)->first();
          $item->user_name = $user->name;
        }
        return response()->json([
            'data' => $items,
        ], 200);
    }

    public function store(Request $request)
    {
        $item = Post::create($request->all());
        return response()->json([
            'data' => $item
        ], 201);
    }

    public function show(Post $post)
    {
        $item = Post::find($post);
        $user = User::find($item[0]->user_id)->first();
        $item[0]->user_name = $user->name;
        if ($post) {
            return response()->json([
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
            ], 400);
        }
    }

    public function destroy(Post $post)
    {
        $item = Post::where('id', $post->id)->delete();
        if ($item) {
            return response()->json([
                'message' => 'Deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }
    }

}
