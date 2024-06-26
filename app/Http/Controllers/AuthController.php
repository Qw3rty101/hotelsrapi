<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->merge(['role' => $request->input('role', 'user')]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['Akun Berhasil di buat dan silahkan Login', $user], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['Keterangan login invalid'], 401);
        }

        $user = User::where('email', $request['email'])->first();

        $payload = [
            'iss' => env("APP_URL"),
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        $jwt = JWT::encode($payload, env('FIREBASE_SECRET_KEY'), 'HS256');

        // Simpan user ID ke session
        $request->session()->put('user_id', $user->id);

        // Kembalikan session ID bersama dengan token dan informasi pengguna
        return response()->json([
            'access_token' => $jwt,
            'token_type' => 'Bearer',
            'session_id' => $request->session()->getId(),
            'user' => $user->only(['id', 'name', 'email', 'role']) // Informasi pengguna yang dikembalikan
        ]);
    }


    // Tambahkan method untuk mengambil data user dari session
    public function getUserData(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if ($userId) {
            $user = User::find($userId);
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'No user logged in'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        Cache::put('blacklisted_token:' . $token, true, now()->addHours(1));

        return response()->json(['Sudah berhasil Log out']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                $payload = [
                    'iss' => env("APP_URL"),
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'sub' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ];

                $jwt = JWT::encode($payload, env('FIREBASE_SECRET_KEY'), 'HS256');

                // return response()->json(['access_token' => $jwt, 'token_type' => 'Bearer']);
                return response()->json([
                    'access_token' => $jwt,
                    'token_type' => 'Bearer',
                    'user' => $user->only(['id', 'name', 'email', 'role']) // Informasi pengguna yang dikembalikan
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('Pengen_masuk'),
                    'role' => 'user',
                ]);

                $payload = [
                    'iss' => env("APP_URL"),
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'sub' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ];

                $jwt = JWT::encode($payload, env('FIREBASE_SECRET_KEY'), 'HS256');

                // return response()->json(['access_token' => $jwt, 'token_type' => 'Bearer']);
                return response()->json([
                    'access_token' => $jwt,
                    'token_type' => 'Bearer',
                    'user' => $user->only(['id', 'name', 'email', 'role']) // Informasi pengguna yang dikembalikan
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Google authentication failed', ['exception' => $e->getMessage()]);
            return response()->json(['Gagal Autentikasi dengan Google: ' . $e->getMessage()], 500);
        }
    }

    public function loginWithGoogle(Request $request)
    {
        $password = "1234567890dummy";

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password) 
            ]);
        }

        $credential = [
            "email" => $user->email,
            "password" => $password
        ];

        
        // Authenticate the user manually
        if (!Auth::attempt($credential)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Generate JWT token
        $payload = [
            'iss' => env("APP_URL"),
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        $jwt = JWT::encode($payload, env('FIREBASE_SECRET_KEY'), 'HS256');

        // Simpan user ID ke session
        $request->session()->put('user_id', $user->id);

        // Kembalikan session ID bersama dengan token dan informasi pengguna
        return response()->json([
            'access_token' => $jwt,
            'token_type' => 'Bearer',
            'session_id' => $request->session()->getId(),
            'user' => $user->only(['id', 'name', 'email', 'role']) // Informasi pengguna yang dikembalikan
        ]);
    }
}
