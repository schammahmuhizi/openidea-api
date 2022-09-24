<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $idea = Idea::find($id);

        if(!$idea){
            return response()->json([
                'data',
                "message" => 'Idea not found'
            ], 404);   
        }

        $comment = $idea->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'data' => $comment,
            "message" => 'Comment added'
        ], 201);
    }
}
