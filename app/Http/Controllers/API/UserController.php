<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', new Password]
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            $user = User::where('email', $request->email)->first();
            $token_result = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token_result,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'berhasil daftar ihirr');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'salah anjeng',
                'error' => $error,
            ], 'auth gagal wle wle');
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            if (!Auth::attempt(request(['email', 'password']))) {
                return ResponseFormatter::error([
                    'message' => 'unauthorize',
                ], 'Auth failed', 500);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Unauthorize',
                'error' => $error,
            ], 'auth faild', 500);
        }
    }
}
