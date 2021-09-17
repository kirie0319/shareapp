<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->users()->attach($request->user_id);
        $count = $post->users()->count();
        $result = true;
        return response()->json([
            'result' => $result,
            'count' => $count,
        ], 201);
    }
    public function destroy(Request $request)
    {
        $post = Post::find($request->post_id);
        $post->users()->detach($request->user_id);
        $count = $post->users()->count();
        $result = false;
        return response()->json([
            'result' => $result,
            'count' => $count,
        ], 201);
    }
    public function countlikes(Request $request)
    {
        $post = Post::find($request->post_id);
        $count = $post->users()->count();
        return response()->json([
            'count' => $count
        ], 200);
    }
    public function haslike(Request $request)
    {
        $post = Post::find($request->post_id);
        $hasLikes = $post->users()->where('user_id', $request->user_id)->exists();
        if ($hasLikes) {
            $result = true;
        } else {
            $result = false;
        }
        return response()->json([
            'result'=>$result
        ], 200);
    }
}
