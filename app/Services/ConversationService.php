<?php

namespace App\Services;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationService
{
    /**
     * Create a new class instance.
     */
    public function getUserConversations($userId, $search = null)
    {
        $conversations = Conversation::with([
            'lastMessage',
            'participants.user'
        ]) ->whereHas('participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->when($search, function ($query) use ($search, $userId) {
                $query->whereHas('participants.user', function ($q) use ($search, $userId) {
                    $q->where('name', 'like', "%{$search}%")
                        ->where('id', '!=', $userId);
                });
            })->latest('updated_at')
            ->get();


        return $conversations->map(function ($conversation) use ($userId) {

            $participant = $conversation->participants
                ->firstWhere('user_id', $userId);

            $otherUser = $conversation->participants
                ->firstWhere('user_id', '!=', $userId)
                ?->user;

            $lastMessage = $conversation->lastMessage;

            $unreadCount = $conversation->messages()
                ->where('id', '>', $participant->last_read_message_id ?? 0)
                ->where('sender_id', '!=', $userId)
                ->count();

            return [
                'id' => $conversation->id,
                'name' => $otherUser->name ?? 'Unknown',
                'image' =>$otherUser->media->file_path?? 'storage/uploads/profiles/profile.jpg',
                'last_message' => $lastMessage->message ?? 'No messages yet',
                'time' => optional($lastMessage)->created_at?->format('h:i A'),
                'unread' => $unreadCount,
            ];
        });
    }



    public function showConversation($conversationId, Request $request)
    {

        $userId = auth()->id();
        $conversation = Conversation::with(['participants.user', 'messages.sender'])
            ->findOrFail($conversationId);
        $otherUser = $conversation->participants
            ->firstWhere('user_id', '!=', $userId)?->user;

        $messages = $conversation->messages
            ->sortBy('created_at')
            ->map(function ($message) use ($userId) {
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'message' => $message->message,
                    'time' => $message->created_at->format('h:i A'),
                    'is_me' => $message->sender_id === $userId,
                ];
            });

        return [

                'id' => $otherUser->id ?? null,
                'name' => $otherUser->name ?? 'Unknown',
                'image' => $otherUser->media->file_path ?? 'storage/uploads/profiles/profile.jpg',
                'last_seen' => optional($otherUser)->last_activity_at?->diffForHumans() ?? 'Offline',
                 'messages' => $messages,
        ];


    }

}
