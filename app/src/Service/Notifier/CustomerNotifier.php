<?php

namespace App\Service\Notifier;

use App\Entity\Customer;
use App\Service\Notifier\Notification\MultiChannelNotification;
use App\Service\Notifier\Recipient\MultiChannelRecipient;
use Symfony\Component\Notifier\NotifierInterface;

class CustomerNotifier implements CustomerNotifierInterface
{
    public function __construct(
        private readonly NotifierInterface $notifier,
        private readonly ChannelProviderInterface $channelProvider
    )
    {
    }

    public function send(Customer $customer, string $message): void
    {
        $notification = new MultiChannelNotification($message, [$this->channelProvider->provideInitial()], $customer->getLocale());
        $recipient = new MultiChannelRecipient($customer->getEmail(), $customer->getPhone(), $customer->getPushyToken() ?? 'customer has no pushy token');

        $this->notifier->send($notification, $recipient);
    }
}