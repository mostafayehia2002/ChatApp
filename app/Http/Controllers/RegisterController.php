<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;

    }
    public function index()
    {
        return view('auth.register');
    }
    public function store(RegisterRequest $request)
    {
        $response = $this->registerService->store($request);
        if ($response['success']) {

            notifyMessage(message:$response['message']);

            return redirect()->route('home');

        }
        notifyMessage(message:$response['message'], type:'error');
        return redirect()->back()->withInput($request->only('name', 'email'));
    }
}
