<?php

namespace App\Service\Notifier\Message;

use App\Service\Notifier\Notification\MultiChannelNotification;
use App\Service\Notifier\Recipient\MultiChannelRecipient;

trait FailoverMessageTrait
{
    private MultiChannelRecipient $recipient;
    private MultiChannelNotification $notification;

    public function setRecipient(MultiChannelRecipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getRecipient(): MultiChannelRecipient
    {
        return $this->recipient;
    }

    public function setNotification(MultiChannelNotification $notification): void
    {
        $this->notification = $notification;
    }

    public function getNotification(): MultiChannelNotification
    {
        return $this->notification;
    }
}