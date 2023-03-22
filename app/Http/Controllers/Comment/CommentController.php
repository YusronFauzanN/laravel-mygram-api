<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getComment()
    {
        // Get data
        $comment = Comment::all();

        // return response()->json($comment);
        return CommentResource::collection($comment->loadMissing(['photo', 'user']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validating request
        $validated = $request->validate([
            'comment' => 'required|string',
            'photo_id' => 'required|integer'
        ]);

        // Add user id
        $request['user_id'] = auth()->user()->id;

        // Check if photos exist
        $photo = Photo::find($request->photo_id);

        if (!$photo) {
            return response()->json([
                'message' => 'Photo not found'
            ], 404);
        }

        // Insert Request
        $comment = Comment::create($request->all());

        // return response()->json($comment);
        return new CommentResource($comment->loadMissing(['photo', 'user']));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get data
        $comment = Comment::with(['photo', 'user'])->find($id);
        
        // Check comment
        if (!$comment) {
            return response()->json([
                'message' => 'Data Not Found!'
            ],404);
        }

        // return response()->json($comment);
        return new CommentResource($comment->loadMissing(['photo', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'comment' => 'required|string'
        ]);
        
        // Find users photo
        $comment = Comment::find($id);

        // Update users comment
        $comment->update($request->all());
        
        // return response()->json($comment);
        return new CommentResource($comment->loadMissing(['photo', 'user']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find users photo
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                'message' => 'Data Not Found!'
            ],404);
        }

        // Delete comment
        $comment->delete();

        return response()->json([
            'message' => 'Your comment has been successfully deleted!'
        ]);
    }
}
