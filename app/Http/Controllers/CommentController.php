<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $items = Comment::all();
        foreach($items as $item) {
          $item->post;
          $item->actor;
        }
        return response()->json([
            'data' => $items,
        ], 200);
    }

    public function store(Request $request)
    {
        $item = Comment::create($request->all());
        return response()->json([
            'data' => $item
        ], 201);
    }

}
