<?php

namespace App\Services;
use App\Enums\MessageType;
use App\Http\Requests\StoreChatRequest;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ChatService
{
    /**
     * Create a new class instance.
     */



    public function store(StoreChatRequest $request): array
    {
        $currentUser = Auth::id();
        $data = $request->validated();
        $storedFiles = [];

        try {
            $conversation = Conversation::where('id', $data['conversation_id'])
                ->whereHas('participants', function ($query) use ($currentUser) {
                    $query->where('user_id', $currentUser);
                })
                ->firstOrFail();

            $attachments = $request->file('attachment', []);
            $hasMedia = !empty($attachments);
            $hasText = filled($data['body'] ?? null);

            if ($hasMedia && $hasText) {
                $type = MessageType::TEXT_MEDIA;
            } elseif ($hasMedia) {
                $type = MessageType::MEDIA;
            } else {
                $type = MessageType::TEXT;
            }

            DB::beginTransaction();

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $currentUser,
                'type' => $type->value,
                'message' => $data['body'] ?? null,
            ]);

            if ($hasMedia) {
                foreach ($attachments as $file) {
                    $storedFilePath = $file->store('uploads/messages', 'public');
                    $storedFiles[] = $storedFilePath;

                    $message->media()->create([
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $storedFilePath,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            $conversation->update([
                'last_message_id' => $message->id,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $message,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($storedFiles as $storedFile) {
                if (Storage::disk('public')->exists($storedFile)) {
                    Storage::disk('public')->delete($storedFile);
                }
            }

            Log::error('ChatService@store: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'An error occurred during sending message',
            ];
        }
    }

}
