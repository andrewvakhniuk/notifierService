<?php

namespace App\Service\Notifier\Message;

use App\Service\Notifier\Notification\MultiChannelNotification;

interface NotificationAwareInterface
{
    public function setNotification(MultiChannelNotification $notification): void;

    public function getNotification(): MultiChannelNotification;
}