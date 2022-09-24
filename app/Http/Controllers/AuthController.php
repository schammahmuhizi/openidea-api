<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Generate a token for authenticate API Tokens
        $token = $new_user->createToken('token')->plainTextToken;

        return response()->json([
            'data' => $new_user,
            'token' => $token,
            'message' => 'New user registered'
        ],201);
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->get();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'data',
                "message" => 'Email or password are incorrect'
            ], 401);
        }

        // Generate a token for authenticate API Tokens
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            "message" => 'User logged in'
        ], 200);
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return redirect()->json(['data', 'message' => 'User logged out']);
    }
}
