<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function get()
    {
        return response()->json(User::all());
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            if (!$token = JWTAuth::attempt($request->only("email", "password"))) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid Credentials"
                ], 401);
            }

            $user = Auth::user(); // Get the logged-in user

            return response()->json([
                "status" => true,
                "message" => "User Logged In",
                "token" => $token,
                "role" => $user->role, // 'admin' or 'customer'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => false,
                "message" => "Validation failed",
                "errors" => $e->errors()
            ], 422);
        }
    }


    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                "name" => "required|string",
                "email" => "required|email|unique:users,email",
                "password" => "required",
            ]);
    
            // Hash the password before storing it
            $data['password'] = bcrypt($data['password']);
    
            User::create($data);
    
            return response()->json([
                "status" => true,
                "message" => "User registered successfully"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function me()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'role' => $user->role,
        ]);
    }
}




