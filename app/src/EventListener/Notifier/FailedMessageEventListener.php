<?php

namespace App\EventListener\Notifier;

use App\Service\Notifier\ChannelProviderInterface;
use App\Service\Notifier\Message\FailoverMessageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Event\FailedMessageEvent as MailerFailedMessageEvent;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Notifier\Event\FailedMessageEvent as NotifierFailedMessageEvent;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\NotifierInterface;

#[AsEventListener(event: MailerFailedMessageEvent::class, method: 'onMailerFailedMessageEvent')]
#[AsEventListener(event: NotifierFailedMessageEvent::class, method: 'onNotifierFailedMessageEvent')]
class FailedMessageEventListener
{
    public function __construct(
        private readonly LoggerInterface          $logger,
        private readonly ChannelProviderInterface $channelProvider,
        private readonly NotifierInterface        $notifier,
    )
    {
    }

    public function onMailerFailedMessageEvent(MailerFailedMessageEvent $event): void
    {
        $this->processFail($event->getMessage());
    }

    public function onNotifierFailedMessageEvent(NotifierFailedMessageEvent $event): void
    {
        $this->processFail($event->getMessage());
    }

    private function processFail(MessageInterface|RawMessage $message): void
    {
        if ($message instanceof FailoverMessageInterface) {
            $failedChannel = $message->getNotification()->getChannels($message->getRecipient())[0];
            $nextChannel = $this->channelProvider->provideNextInFailoverOrder($failedChannel);

            if ($nextChannel) {

                $this->logger->warning(sprintf(
                    'Failed to send notification: %s , using channel %s, trying to resend through channel %s ...',
                    (string)$message->getNotification(),
                    $failedChannel,
                    $nextChannel,
                ));

                $notification = clone $message->getNotification();
                $notification->channels([$nextChannel]);

                $this->notifier->send($notification, $message->getRecipient());
            } else {
                $this->logger->error(sprintf('Failed to send notification to %s', $message->getRecipient()));
            }
        }
    }
}