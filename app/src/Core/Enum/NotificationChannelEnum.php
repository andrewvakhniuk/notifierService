<?php

namespace App\Core\Enum;

enum NotificationChannelEnum: string
{
    case PUSHY = 'sms/pushy';
    case TWILIO = 'sms/twilio';
    case EMAIL = 'email';

    public static function getChannels(): array
    {
        return array_map(fn($channel) => $channel->value, self::cases());
    }
}
