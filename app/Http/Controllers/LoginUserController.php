<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Services\LoginUserService;
use Illuminate\Http\Request;

class LoginUserController extends Controller
{
    protected LoginUserService $loginUserService;

    public function __construct(LoginUserService $loginUserService)
    {
        $this->loginUserService = $loginUserService;
    }

    public function index()
    {
        return view('auth.login');

    }

    public function login(LoginUserRequest $request)
    {
        $response = $this->loginUserService->login($request);
        if ($response['success']) {
            notifyMessage(message:$response['message']);

            return redirect()->route('home');
        }
        //notify a message
        notifyMessage(message:$response['message'], type:'error');

        return redirect()->back()->withInput($request->only('email', 'password'));
    }
}
