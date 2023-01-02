<?php

namespace App\Service\Notifier\Factory;

use App\Service\Notifier\Message\CustomSmsMessage;
use App\Service\Notifier\Notification\MultiChannelNotification;
use App\Service\Notifier\Recipient\MultiChannelRecipient;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

class SmsMessageFactory
{
    public static function createFromNotification(MultiChannelNotification $notification, RecipientInterface $recipient): SmsMessage
    {
        if ('' === $recipient->getPhone()) {
            throw new \InvalidArgumentException(sprintf('"%s" needs a phone number, it cannot be empty.', __CLASS__));
        }

        if(!$recipient instanceof MultiChannelRecipient) {
            throw new \InvalidArgumentException(sprintf('"%s" needs a "%s" instance, "%s" given.', __CLASS__, MultiChannelRecipient::class, get_class($recipient)));
        }

        $sms = (new CustomSmsMessage($recipient->getPhone(), $notification->getSubject(), $recipient->getPushyToken()));
        $sms->setLocale($notification->getLocale());
        $sms->setRecipient($recipient);
        $sms->setNotification($notification);

        return $sms;
    }
}