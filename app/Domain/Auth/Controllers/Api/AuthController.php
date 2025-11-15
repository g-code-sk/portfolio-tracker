<?php

namespace App\Domain\Auth\Controllers\Api;

use App\Domain\Auth\Data\RegisterData;
use App\Domain\Auth\Data\LoginData;
use App\Domain\Auth\Responses\AuthTokenResponse;
use App\Domain\Auth\Responses\AuthUserResponse;
use App\Domain\Auth\Responses\LogoutResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Register a new user and return token
     */
    public function register(RegisterData $data)
    {
        $user = User::register($data);
        $token = $user->createToken($data->device_name)->plainTextToken;

        return AuthTokenResponse::make('User registered successfully', $user, $token, Response::HTTP_CREATED);
    }

    /**
     * Login user and return token
     */
    public function login(LoginData $data)
    {
        $user = User::attemptLogin($data->email, $data->password);
        $token = $user->createToken($data->device_name)->plainTextToken;

        return AuthTokenResponse::make('Login successful', $user, $token);
    }

    /**
     * Logout user (revoke current token)
     */
    public function logout(Request $request)
    {
        $request->user()->logoutCurrentDevice();

        return LogoutResponse::make('Logout successful');
    }

    /**
     * Logout from all devices (revoke all tokens)
     */
    public function logoutAll(Request $request)
    {
        $request->user()->logoutFromAllDevices();

        return LogoutResponse::make('Logged out from all devices');
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        return AuthUserResponse::make($request->user());
    }

    /**
     * Get user's active tokens/devices
     */
    public function devices(Request $request)
    {
        $tokens = $request->user()->tokens()->get()->map(function ($token) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'last_used_at' => $token->last_used_at,
                'created_at' => $token->created_at,
            ];
        });

        return response()->json([
            'devices' => $tokens,
        ]);
    }

    /**
     * Revoke a specific token/device
     */
    public function revokeDevice(Request $request, $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return LogoutResponse::make('Device logged out successfully');
    }
}
