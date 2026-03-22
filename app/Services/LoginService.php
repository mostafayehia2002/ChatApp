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
        $data=$request->validated();
        try {
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']],true)){
                return [
                    'success' => true,
                    'message' => 'Login Successful'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid Credentials'
                ];
            }
        }catch (\Throwable $e) {
            Log::error('LoginUserService@login: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An Error Occurred During Login'
            ];
        }

    }
}
