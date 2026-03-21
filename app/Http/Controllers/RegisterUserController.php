<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\RegisterUserService;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    //
    protected RegisterUserService $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;

    }
    public function index()
    {
        return view('auth.register');
    }
    public function store(RegisterUserRequest $request)
    {
        $response = $this->registerUserService->store($request);
        if ($response['success']) {

            notifyMessage(message:$response['message']);

            return redirect()->route('home');

        }
        notifyMessage(message:$response['message'], type:'error');
        return redirect()->back()->withInput($request->only('name', 'email'));
    }
}
