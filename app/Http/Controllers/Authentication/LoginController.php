<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $user = User::where('email', $loginRequest->email)->first();
        if (
            $user instanceof User &&
            Hash::check($loginRequest->password, $user->password)
        ) {
            Cache::put($user->email, $user, 1800);
            return response()->json($user, 200);
        }

        $errorResponse = [
            "password" => [
                0 => "Invalid Email or password"
            ]
        ];

        $error = \Illuminate\Validation\ValidationException::withMessages($errorResponse);
        throw $error;
    }
}
