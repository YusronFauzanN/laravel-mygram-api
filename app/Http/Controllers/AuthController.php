<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validating request
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'full_name' => 'required|string',
            'username' => 'required|unique:users|string|min:4|max:12',
            'password' => ['required', Password::min(6)->mixedCase()],
            'profile_image_url' => 'required|url',
            'age' => 'required|integer',
            'phone_number' => 'required|string|min:12',
        ]);

        // Hashing password
        $request['password'] = Hash::make($request['password']);

        // Insert Request
        $user = User::create($request->all());

        // return response()->json($user);
        return New AuthResource($user);
    }

    public function login(Request $request)
    {
        // Validating request
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => ['required', Password::min(6)->mixedCase()]
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user null or password not same
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email or password are incorrect!']
            ]);
        }

        return response()->json([
            'token' => $user->createToken('User Login')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        // Delete token
        $request->user()->currentAccessToken()->delete();
    }
}
