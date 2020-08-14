<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Users\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(
                [
                    'message' => ['These credentials do not match our records.'],
                ],
                404
            );
        }

        $tokenName = $user->id . ' - id user token';

        $token = $user->createToken($tokenName)->plainTextToken;

        $response = [
            'user'         => $user,
            'access_token' => $token,
        ];

        return response($response, 201);
    }
}
