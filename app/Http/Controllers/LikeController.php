<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    public function like($id)
    {

        $like = Like::updateOrCreate(['user_id' => auth()->id(), 'idea_id' => $id]);

        return response()->json([
            'data' => $like,
            "message" => 'Like added',
        ], 201);

    }

    public function unlike($id)
    {
        $unlike = Like::where('user_id', '=', auth()->id())
            ->where('idea_id', '=', $id)
            ->delete();

        return response()->json([
            'data' => $unlike,
            "message" => 'Like removed',
        ], 200);
    }
}
