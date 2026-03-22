<?php

namespace App\Http\Controllers;

use App\Services\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    protected LogoutService $logoutService;

    public function __construct(LogoutService $logoutService)
    {

        $this->logoutService = $logoutService;

    }

    public function logout()
    {
        $response = $this->logoutService->logout();
        if ($response['success']) {
            notifyMessage(message: $response['message']);
            return redirect()->route('login');
        }
        notifyMessage(message: $response['message'], type: 'error');
        return redirect()->back();
    }
}
