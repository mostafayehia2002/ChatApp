<?php

namespace App\Services;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginUserService
{
    /**
     * Create a new class instance.
     */
    public function login(LoginUserRequest $request): array
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
