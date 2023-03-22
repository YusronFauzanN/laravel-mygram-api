<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // Validating request
        $validated = $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string',
            'username' => 'required|string|min:4|max:12',
            'profile_image_url' => 'required|url',
            'age' => 'required|integer',
            'phone_number' => 'required|string|min:12',
        ]);

        // Find user data
        $user = User::findOrFail(auth()->user()->id);

        // Update user data
        $user->update($request->all());

        // return response()->json($user);
        return new UserResource($user);
    }

    public function profile(){
        // Get users data by their user id
        $user = User::findOrFail(Auth()->user()->id);

        // return response()->json($user);
        return new UserResource($user);
    }

    public function test()
    {
        dd('Masuk Author');
    }
}
