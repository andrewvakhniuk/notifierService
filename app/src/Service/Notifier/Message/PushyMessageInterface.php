<?php

namespace App\Service\Notifier\Message;

use Symfony\Component\Notifier\Message\MessageInterface;

interface PushyMessageInterface extends MessageInterface
{
    public function getPushyToken(): string;
}
