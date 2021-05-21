<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;



class AuthController extends Controller
{

    public function register(Request $request){
        $field = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $field['name'],
            'email' => $field['email'],
            'password' => bcrypt($field['password'])
        ]);

        $token = $user->createToken('Token')->plainTextToken;

        $response = [
            'message'=> 'User Registered',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response,201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        $response= [
            'message' => 'logout',
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request){
        $field = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email' , $field['email'])->first();

        if(!$user || !Hash::check($field['password'], $user->password)){
            return response([
                'message' => 'Pass atau email salah'
            ]);
        }


        $token = $user->createToken('Token')->plainTextToken;

        $response = [
            'message'=> 'Login Successfully',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response,201);
    }

}
