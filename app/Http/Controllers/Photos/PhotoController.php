<?php

namespace App\Http\Controllers\Photos;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPhoto()
    {
        // Get data
        $photos = Photo::all();

        // return response()->json($photos);
        return PhotoResource::collection($photos->loadMissing(['user:id,username,profile_image_url', 'comments:id,photo_id,user_id,comment']));
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
            'poster_image_url' => 'required|url',
            'title' => 'required|string',
            'caption' => 'required|string',
        ]);

        // Add user id
        $request['user_id'] = auth()->user()->id;

        // Insert Request
        $photo = Photo::create($request->all());

        // return response()->json($photo);
        return new PhotoResource($photo->loadMissing(['user:id,username,profile_image_url', 'comments:id,photo_id,user_id,comment']));
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
        $photo = Photo::find($id);
        
        // Check photo
        if (!$photo) {
            return response()->json([
                'message' => 'Data Not Found!'
            ],404);
        }

        // return response()->json($photo);
        return new PhotoResource($photo->loadMissing(['user:id,username,profile_image_url', 'comments:id,photo_id,user_id,comment']));
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
            'poster_image_url' => 'required|url',
            'title' => 'required|string',
            'caption' => 'required|string',
        ]);
        
        // Find users photo
        $photo = Photo::find($id);

        // Update users photo
        $photo->update($request->all());
        
        // return response()->json($photo);
        return new PhotoResource($photo->loadMissing(['user:id,username,profile_image_url', 'comments:id,photo_id,user_id,comment']));
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
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json([
                'message' => 'Data Not Found!'
            ],404);
        }

        // Delete photo
        $photo->delete();

        return response()->json([
            'message' => 'Your photo has been successfully deleted!'
        ]);
    }
}
