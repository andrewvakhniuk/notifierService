<?php

namespace App\Service\Notifier\Notification;

use App\Core\Enum\LocaleEnum;
use App\Service\Notifier\Factory\EmailMessageFactory;
use App\Service\Notifier\Factory\SmsMessageFactory;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Notification\SmsNotificationInterface;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;

class MultiChannelNotification extends Notification implements SmsNotificationInterface, EmailNotificationInterface, LocaleAwareInterface
{
    public function __construct(string $subject = '', array $channels = [], private LocaleEnum $locale = LocaleEnum::DEFAULT)
    {
        parent::__construct($subject, $channels);
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        return EmailMessageFactory::createFromNotification($this, $recipient);
    }

    /**
     * Apparently all texter transports go as SMS Channel. That is why Pushy and Twilio are SMS channels.
     *
     * @param SmsRecipientInterface $recipient
     * @param string|null $transport
     * @return SmsMessage|null
     */
    public function asSmsMessage(SmsRecipientInterface $recipient, string $transport = null): ?SmsMessage
    {
        return SmsMessageFactory::createFromNotification($this, $recipient);
    }

    public function setLocale(LocaleEnum $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): LocaleEnum
    {
        return $this->locale;
    }

    public function __toString(): string
    {
        return sprintf('Notification details - subject: %s', $this->getSubject());
    }
}