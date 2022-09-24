<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index(Request $request)
    {

        return response()->json([
            'data' => Idea::latest()->filter(request('tag'))->paginate()->withQueryString(),
            'message' => 'Ideas retrieved successfully'
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tags' => 'required'
        ]);

        $idea = Idea::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);

        foreach ($request->tags as $tag) {
            $idea->tags()->create([
                'name' => $tag
            ]);
        }

        return response()->json([
            'data' => $idea,
            'message' => 'New idea created'
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tags' => 'required'
        ]);

        $idea = Idea::find($id);

        if(!$idea){
            return response()->json([
                'data',
                'message' => 'Idea not exist'
            ], 404);
        }

        $idea->title = $request->title;
        $idea->content = $request->content;
        $idea->user_id = auth()->id();
        $idea->save();

        foreach ($request->tags as $tag) {
            $idea->tags()->create([
                'name' => $tag
            ]);
        }

        return response()->json([
            'data' => $idea,
            'message' => 'Idea updated'
        ], 200);
        
    }

    public function destroy($id)
    {
        $idea = Idea::find($id);

        if(!$idea){
            return response()->json([
                'data',
                'message' => 'Idea not exist'
            ], 404);
        }

        $idea->delete();

        return response()->json([
            'data',
            'message' => 'Idea deleted'
        ], 200);
    }
}
