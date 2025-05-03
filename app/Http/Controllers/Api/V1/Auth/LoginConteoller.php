<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginConteoller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
        ]);

        // $device = substr($request->userAgent() ?? '', 0, 255);

        // return response()->json([
        //     'access_token' => $user->createToken($device)->plainTextToken,
        // ]);

    }
}
