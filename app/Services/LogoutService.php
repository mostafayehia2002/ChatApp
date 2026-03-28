<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutService
{
    /**
     * Create a new class instance.
     */

    public function logout()
    {
        try {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return [
                'success' => true,
                'message' => 'Logout Successfully'
            ];
        } catch (\Throwable $e) {

            Log::error('LogoutService@logout: ' . $e->getMessage());
            return [
                'success' => false,
                'message' =>'An error occured while logging out'
            ];
        }
    }
}
