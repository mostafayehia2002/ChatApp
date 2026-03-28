<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function login(LoginRequest $request): array
    {
        $credentials=$request->validated();
        try {
            $authenticated = Auth::attempt(
                [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ],
                false
            );
            if ($authenticated) {
                $request->session()->regenerate();
                return [
                    'success' => true,
                    'message' => 'Login successful',
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid credentials',
            ];
        }catch (\Throwable $e) {
            Log::error('LoginService@login: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An Error Occurred During Login'
            ];
        }

    }
}
