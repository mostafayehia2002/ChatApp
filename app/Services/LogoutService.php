<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    /**
     * Create a new class instance.
     */

    public function logout()
    {
        try {
            Auth::logout();
            return [
                'success' => true,
                'message' => 'Logout Successfully'
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
