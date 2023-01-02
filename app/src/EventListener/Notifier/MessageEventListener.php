<?php

namespace App\EventListener\Notifier;

use App\Service\Notifier\Message\TranslatableInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Event\MessageEvent as MailerMessageEvent;
use Symfony\Component\Notifier\Event\MessageEvent as NotifierMessageEvent;
use Symfony\Contracts\Translation\TranslatorInterface;


#[AsEventListener(event: MailerMessageEvent::class, method: 'onMailerMessageEvent')]
#[AsEventListener(event: NotifierMessageEvent::class, method: 'onNotifierMessageEvent')]
class MessageEventListener
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function onMailerMessageEvent(MailerMessageEvent $event): void
    {
        $this->processMessage($event->getMessage());
    }

    public function onNotifierMessageEvent(NotifierMessageEvent $event): void
    {
        $this->processMessage($event->getMessage());
    }

    private function processMessage($message): void
    {
        if($message instanceof TranslatableInterface) {
            $message->translateMe($this->translator);
        }
    }
}