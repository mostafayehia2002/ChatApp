<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatService
{
    /**
     * Create a new class instance.
     */

    public function store($request): array
    {
        try {
            $authUser = auth()->user();
            DB::beginTransaction();
                // 1️⃣ check user
                $receiver = User::where('email', $request->email)->first();
                if (!$receiver) {
                    return [
                        'success' => false,
                        'message' => 'User not found'
                    ];
                }

                if ($receiver->id === $authUser->id) {
                    return [
                        'success' => false,
                        'message' => 'You cannot message yourself'
                    ];
                }

                // 2️⃣ check if conversation exists
                $conversation = Conversation::whereHas('participants', function ($q) use ($authUser) {
                    $q->where('user_id', $authUser->id);
                })->whereHas('participants', function ($q) use ($receiver) {
                    $q->where('user_id', $receiver->id);
                })->first();

                // 3️⃣ create conversation if not exists
                if (!$conversation) {
                    $conversation = Conversation::create();
                    $conversation->participants()->createMany([
                        ['user_id' => $authUser->id],
                        ['user_id' => $receiver->id],
                    ]);
                }

                // 4️⃣ create message
                $message = Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $authUser->id,
                    'message' => $request->message,
                    'type' => 'text',
                ]);

                // 5️⃣ update last message
                $conversation->update([
                    'last_message_id' => $message->id
                ]);

                DB::commit();
                return [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'conversation_id' => $conversation->id
                ];
        }catch (\Throwable $e){
            DB::rollBack();
            Log::error('ChatService@store: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


}
