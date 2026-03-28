<?php

namespace App\Enums;

enum MessageType : int
{
    case TEXT = 1;
    case MEDIA = 2;
    case TEXT_MEDIA = 3;


    public function label(): string
    {
        return match ($this) {
            self::TEXT =>'text',
            self::MEDIA => 'media',
            self::TEXT_MEDIA => 'text_media',
        };
    }

}
