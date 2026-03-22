<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    protected ProfileService $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit()
    {

        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function update(UpdateProfileRequest $request){

        $response = $this->profileService->update($request);
        if ($response['success']) {

            notifyMessage(message:$response['message']);

            return redirect()->route('home');

        }
        notifyMessage(message:$response['message'], type:'error');
        return redirect()->back();

    }

}
