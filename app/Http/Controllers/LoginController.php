<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function index()
    {
        return view('auth.login');

    }

    public function login(LoginRequest $request)
    {
        $response = $this->loginService->login($request);
        if ($response['success']) {
            notifyMessage(message:$response['message']);

            return redirect()->route('home');
        }
        //notify a message
        notifyMessage(message:$response['message'], type:'error');

        return redirect()->back()->withInput($request->only('email'));
    }
}
