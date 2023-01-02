<?php

namespace App\Service\Notifier\Transport\Pushy;

use App\Service\Notifier\Message\PushyMessageInterface;
use App\Service\PushyClient\PushyClientInterface;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\Notifier\Transport\AbstractTransport;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class PushyTransport extends AbstractTransport
{
    public const TRANSPORT = 'pushy';

    public function __construct(private readonly PushyClientInterface $pushyClient, HttpClientInterface $client = null, EventDispatcherInterface $dispatcher = null)
    {
        parent::__construct($client, $dispatcher);
    }

    protected function doSend(MessageInterface $message): SentMessage
    {
        if(!$message instanceof PushyMessageInterface) {
            throw new \InvalidArgumentException('Message must be an instance of PushyMessageInterface');
        }

        $this->pushyClient->sendPushNotification($message->getPushyToken(), $message->getSubject());

        return new SentMessage($message, (string) $this);
    }

    public function supports(MessageInterface $message): bool
    {
        return self::TRANSPORT === $message->getTransport();
    }

    public function __toString(): string
    {
        return self::TRANSPORT;
    }
}