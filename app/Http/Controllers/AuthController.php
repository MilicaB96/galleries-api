<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = Auth::login($user);
        return response()->json(compact('token', 'user'));
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();
        return response()->json(compact('token', 'user'));
    }
    public function logout()
    {
        Auth::logout();
        return response(null, 204);
    }
}
