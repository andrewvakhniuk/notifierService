<?php

namespace App\Service\Notifier\Recipient;

use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

class MultiChannelRecipient implements EmailRecipientInterface, SmsRecipientInterface, PushyRecipientInterface
{
    public function __construct(
        private readonly string $email,
        private readonly string $phone,
        private readonly string $pushyToken,
    )
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPushyToken(): string
    {
        return $this->pushyToken;
    }

    public function __toString(): string
    {
        return sprintf('Recipient details - email: %s, phone: %s, pushyToken: %s', $this->email, $this->phone, $this->pushyToken);
    }
}