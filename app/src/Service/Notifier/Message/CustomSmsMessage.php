<?php

namespace App\Service\Notifier\Message;

use App\Core\Enum\LocaleEnum;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\SmsRecipientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomSmsMessage extends SmsMessage implements FailoverMessageInterface, TranslatableInterface, PushyMessageInterface
{
    use FailoverMessageTrait;

    private LocaleEnum $locale;

    public function __construct(string $phone, string $subject, private readonly ?string $pushyToken = null, string $from = '')
    {
        parent::__construct($phone, $subject, $from);
    }

    public function setLocale(LocaleEnum $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): LocaleEnum
    {
        return $this->locale;
    }

    public function translateMe(TranslatorInterface $translator): void
    {
        $this->subject($translator->trans($this->getSubject(), locale: $this->locale->value));
    }

    public static function fromNotification(Notification $notification, SmsRecipientInterface $recipient): SmsMessage
    {
        return new self($recipient->getPhone(), $notification->getSubject());
    }

    public function getPushyToken(): string
    {
        return $this->pushyToken;
    }
}