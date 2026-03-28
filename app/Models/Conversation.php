<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{

    protected $fillable = [
        'last_message_id',
    ];

    public function participants():HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }


    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withTimestamps();
    }

    public function lastMessage():BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }


}
