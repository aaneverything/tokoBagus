<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

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
                'password' => ['required', 'string', Password::min(8)]
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
            ], 'Registrasi berhasil');
        } catch (ValidationException $e) {
            return ResponseFormatter::error(
                $e->errors(),
                'Validation error',
                422
            );
        } catch (\Throwable $e) {
            return ResponseFormatter::error(
                null,
                'Server error',
                500
            );
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
                    'message' => 'Unauthorized',
                ], 'Login gagal, email atau password salah', 401);
            }

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authenticated');
        } catch (ValidationException $e) {
            return ResponseFormatter::error(
                $e->errors(),
                'Validation error',
                422
            );
        } catch (\Throwable $e) {
            return ResponseFormatter::error(
                null,
                'Server error',
                500
            );
        }
    }

    public function fetchUser(Request $request)
    {
        return ResponseFormatter::success(
            $request->user(),
            'data profil user berhasil diambil'
        );
    }

    public function UpdateUser(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username,' . Auth::id()],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
                'phone' => ['nullable', 'string', 'max:255'],
            ]);
            $data = $request->only(['name', 'username', 'email', 'phone']);
            $user = Auth::user();
            $user->update($data);
            return ResponseFormatter::success($user, 'Profile berhasil diupdate');
        } catch (Exception $error) {
            return ResponseFormatter::error(
                null,
                'Gagal mengupdate profile',
                500
            );
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }
        return ResponseFormatter::success(null, 'Logout berhasil');
    }
}
