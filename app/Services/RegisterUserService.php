<?php

namespace App\Services;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterUserService
{
    /**
     * Create a new class instance.
     */


    public function store(RegisterUserRequest $request): array
    {
        DB::beginTransaction();
        try {
            $data=$request->validated();
            $data['password']=Hash::make($data['password']);
            $user = User::create($data);
            Auth::login($user);
            DB::commit();
            return [
                'success' => true,
                'message' => 'Successfully Registered',
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('RegisterUserService@store: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An Error Occurred During Register'
            ];
        }
    }
}
