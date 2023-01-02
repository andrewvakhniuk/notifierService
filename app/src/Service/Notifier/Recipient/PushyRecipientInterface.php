<?php

namespace App\Service\Notifier\Recipient;

use Symfony\Component\Notifier\Recipient\RecipientInterface;

interface PushyRecipientInterface extends RecipientInterface
{
    public function getPushyToken(): string;
}