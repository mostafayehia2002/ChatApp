<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConversationService
{
    /**
     * Public Methods
     */

    public function store($request): array
    {
        $authUser = auth()->user();
        $data = $request->validated();
        try {
            $receiver = User::where('email', $data['email'])->firstOrFail();

            DB::beginTransaction();
            $conversation = $this->findOrCreateConversation($authUser, $receiver);
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $authUser->id,
                'message' => $data['message'],
                'type' => MessageType::TEXT->value,
            ]);
            $conversation->update(['last_message_id' => $message->id]);
            DB::commit();
            return [
                'success' => true,
                'message' => 'Message sent successfully',
                'conversation_id' => $conversation->id,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ConversationService@store: ' . $e->getMessage());

            return ['success' => false, 'message' => 'An error occurred.'];
        }
    }

    public function getUserConversations($userId, $search = null)
    {
        $conversations = Conversation::with(['lastMessage', 'participants.user.media'])
            ->whereHas('participants', fn ($q) => $q->where('user_id', $userId))
            ->when($search, function ($query) use ($search, $userId) {
                $query->whereHas('participants.user', function ($q) use ($search, $userId) {
                    $q->where('name', 'like', "%{$search}%")->where('id', '!=', $userId);
                });
            })
            ->latest('updated_at')
            ->get();

        return $conversations->map(function ($conversation) use ($userId) {
            $participant = $conversation->participants->firstWhere('user_id', $userId);
            $otherUser = $conversation->participants->firstWhere('user_id', '!=', $userId)?->user;
            $unreadCount = $conversation->messages()
                ->where('id', '>', $participant->last_read_message_id ?? 0)
                ->where('sender_id', '!=', $userId)
                ->count();

            return [
                'id' => $conversation->id,
                'name' => $otherUser?->name ?? 'Unknown',
                'image' => $otherUser?->media?->file_url ?? asset('storage/uploads/profiles/profile.jpg'),
                'last_message' => $conversation->lastMessage?->message ?? 'No messages yet',
                'time' => $conversation->lastMessage?->created_at?->format('h:i A'),
                'unread' => $unreadCount,
            ];
        });
    }

    public function showConversation(int $conversationId, int $currentUserId, ?int $lastMessageId = null): array
    {
        $conversation = $this->getAuthorizedConversation($conversationId, $currentUserId);
        $otherUser = $conversation->participants->firstWhere('user_id', '!=', $currentUserId)?->user;

        $messagesData = $this->getFormattedMessages($conversationId, $currentUserId, $otherUser?->id, $lastMessageId);

        if (!$lastMessageId) {
            $this->markMessagesAsRead($messagesData['models'], $conversationId, $currentUserId);
        }

        return [
            'conversation' => ['id' => $conversation->id],
            'chat_user' => [
                'id' => $otherUser?->id,
                'name' => $otherUser?->name ?? 'Unknown',
                'image' => $otherUser?->media?->file_url ?? asset('storage/uploads/profiles/profile.jpg'),
                'last_seen' => $otherUser?->last_activity_at?->diffForHumans() ?? 'Offline',
            ],
            'messages' => $messagesData['formatted'],
        ];
    }

    public function getMoreMessages(int $conversationId, int $currentUserId, ?int $lastMessageId = null): array
    {
        return $this->getFormattedMessages($conversationId, $currentUserId, null, $lastMessageId);
    }

    /**
     * Helper Methods
     */

    private function findOrCreateConversation(User $user1, User $user2): Conversation
    {
        $conversation = Conversation::whereHas('participants', fn ($q) => $q->where('user_id', $user1->id))
            ->whereHas('participants', fn ($q) => $q->where('user_id', $user2->id))
            ->has('participants', '=', 2)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->createMany([
                ['user_id' => $user1->id],
                ['user_id' => $user2->id],
            ]);
        }

        return $conversation;
    }

    private function getAuthorizedConversation(int $conversationId, int $currentUserId): Conversation
    {
        return Conversation::with(['participants.user.media'])
            ->where('id', $conversationId)
            ->whereHas('participants', fn ($q) => $q->where('user_id', $currentUserId))
            ->firstOrFail();
    }

    private function getMessagesQuery(int $conversationId): Builder
    {
        return Message::with(['reads', 'media'])->where('conversation_id', $conversationId)->orderByDesc('id');
    }

    private function getFormattedMessages(int $conversationId, int $currentUserId, ?int $otherUserId = null, ?int $lastMessageId = null): array
    {
        if (is_null($otherUserId)) {
            $conversation = $this->getAuthorizedConversation($conversationId, $currentUserId);
            $otherUserId = $conversation->participants->firstWhere('user_id', '!=', $currentUserId)?->user?->id;
        }

        $query = $this->getMessagesQuery($conversationId);

        if ($lastMessageId) {
            $query->where('id', '<', $lastMessageId);
        }

        $messagesModels = $query->limit(20)->get()->reverse()->values();

        $formattedMessages = $messagesModels->map(function ($message) use ($currentUserId, $otherUserId) {
            $readByOtherUser = $message->reads->firstWhere('user_id', $otherUserId);

            return [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'is_me' => $message->sender_id === $currentUserId,
                'body' => $message->message,
                'time' => $message->created_at->format('h:i A'),
                'is_read' => $message->sender_id === $currentUserId ? (bool) $readByOtherUser : false,
                'read_at' => $message->sender_id === $currentUserId ? $readByOtherUser?->read_at?->format('h:i A') : null,
                'media' => $message->media->map(fn ($media) => [
                    'file_name' => $media->file_name,
                    'file_url' => $media->file_url,
                    'media_category' => $media->media_category,
                    'human_file_size' => $media->human_file_size,
                ])->values(),
            ];
        })->values();

        return [
            'models' => $messagesModels,
            'formatted' => $formattedMessages,
        ];
    }

    private function markMessagesAsRead(Collection $messages, int $conversationId, int $currentUserId): void
    {
        $unreadMessages = $messages->filter(fn ($msg) => $msg->sender_id !== $currentUserId);

        if ($unreadMessages->isEmpty()) return;

        $messageIds = $unreadMessages->pluck('id');

        $existingReads = DB::table('message_reads')
            ->whereIn('message_id', $messageIds)
            ->where('user_id', $currentUserId)
            ->pluck('message_id');

        $newReads = $messageIds->diff($existingReads);

        if ($newReads->isNotEmpty()) {
            $insertData = $newReads->map(fn ($id) => [
                'message_id' => $id,
                'user_id' => $currentUserId,
                'read_at' => now(),
            ])->all();
            DB::table('message_reads')->insert($insertData);
        }

        $lastMessageId = $messageIds->max();

        if ($lastMessageId) {
            ConversationParticipant::updateOrCreate(
                ['conversation_id' => $conversationId, 'user_id' => $currentUserId],
                ['last_read_message_id' => $lastMessageId]
            );
        }
    }
}
