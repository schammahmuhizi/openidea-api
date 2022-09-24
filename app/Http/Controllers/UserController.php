<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => User::latest()->paginate()
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if($user){
            return response()->json(['data' => $user, 'message' => 'User has been retrieved'],201);

        } else{
            return response()->json(['data', 'message' => 'User not found'], 404);
        }
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'email|required|unique:users,email,'. auth()->id(),
            'password' => 'required|min:8',
        ]);
        
        $user = User::find($id);

        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;

            $user->save();

            return response()->json(['data' => $user, 'message' => 'User updated'],200);
        } else{
            return response()->json(['data', 'message' => 'User not found'], 404);
        }
    }

    public function destroy($id)
    {
        
    }
}
