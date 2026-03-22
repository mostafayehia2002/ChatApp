<?php

namespace App\Services;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function update(UpdateProfileRequest $request): array
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $data = $request->validated();
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }else{
                unset($data['password']);
            }
            $user->update($data);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/profiles', $fileName, 'public');
                $mediaData = [
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ];

                if ($user->media) {
                    if (Storage::disk('public')->exists($user->media->file_path)) {

                        Storage::disk('public')->delete($user->media->file_path);
                    }
                    $user->media->update($mediaData);
                } else {
                    $user->media()->create($mediaData);
                }
            }

            DB::commit();
            return [
                'success' => true,
                'message' => 'Profile updated successfully!'
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ProfileService@update: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            return [
                'success' => false,
                'message' => 'An error occurred during updating profile.'
            ];
        }
    }
}
