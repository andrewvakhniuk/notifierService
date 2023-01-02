<?php

namespace App\Service\Notifier\Message;

use App\Service\Notifier\Recipient\MultiChannelRecipient;

interface RecipientAwareInterface
{
    public function setRecipient(MultiChannelRecipient $recipient): void;
    public function getRecipient(): MultiChannelRecipient;
}