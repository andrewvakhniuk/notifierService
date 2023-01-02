<?php

namespace App\EventListener\Notifier;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Event\SentMessageEvent as MailerMessageSentEvent;
use Symfony\Component\Mailer\SentMessage as MailerSentMessage;
use Symfony\Component\Notifier\Event\SentMessageEvent as NotifierMessageSentEvent;
use Symfony\Component\Notifier\Message\SentMessage as NotifierSentMessage;
use Symfony\Component\Serializer\SerializerInterface;


#[AsEventListener(event: MailerMessageSentEvent::class, method: 'onMailerMessageSentEvent')]
#[AsEventListener(event: NotifierMessageSentEvent::class, method: 'onNotifierMessageSentEvent')]
class MessageSentEventListener
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    public function onMailerMessageSentEvent(MailerMessageSentEvent $event): void
    {
        $this->processMessage($event->getMessage());
    }

    public function onNotifierMessageSentEvent(NotifierMessageSentEvent $event): void
    {
        $this->processMessage($event->getMessage());
    }

    private function processMessage(MailerSentMessage|NotifierSentMessage $message): void
    {
        $this->logger->info(sprintf('Notification was sent: %s .', $this->serializer->serialize($message, 'json')));
    }
}