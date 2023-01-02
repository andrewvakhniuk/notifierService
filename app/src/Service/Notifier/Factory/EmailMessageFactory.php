<?php

namespace App\Service\Notifier\Factory;

use App\Service\Mailer\Notification\CustomEmailNotification;
use App\Service\Notifier\Notification\MultiChannelNotification;
use App\Service\Notifier\Recipient\MultiChannelRecipient;
use Symfony\Component\Notifier\Exception\InvalidArgumentException;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;

class EmailMessageFactory
{
    public static function createFromNotification(MultiChannelNotification $notification, EmailRecipientInterface $recipient): EmailMessage
    {
        if ('' === $recipient->getEmail()) {
            throw new InvalidArgumentException(sprintf('"%s" needs an email, it cannot be empty.', __CLASS__));
        }

        if(!$recipient instanceof MultiChannelRecipient) {
            throw new InvalidArgumentException(sprintf('"%s" needs a "%s" instance, "%s" given.', __CLASS__, MultiChannelRecipient::class, get_class($recipient)));
        }

        $email = (new CustomEmailNotification())
            ->to($recipient->getEmail())
            ->subject($notification->getSubject())
            ->content($notification->getContent() ?: $notification->getSubject())
            ->importance($notification->getImportance());

        $email->setLocale($notification->getLocale());
        $email->setRecipient($recipient);
        $email->setNotification($notification);

        if ($exception = $notification->getException()) {
            $email->exception($exception);
        }

        return new EmailMessage($email);
    }
}