<?php

namespace App\Service\Mailer\Notification;

use App\Core\Enum\LocaleEnum;
use App\Service\Notifier\Message\FailoverMessageInterface;
use App\Service\Notifier\Message\FailoverMessageTrait;
use App\Service\Notifier\Message\TranslatableInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomEmailNotification extends NotificationEmail implements FailoverMessageInterface, TranslatableInterface
{
    use FailoverMessageTrait;

    private LocaleEnum            $locale;

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
        $this->content($translator->trans($this->getContent(), locale: $this->locale->value));
    }

    protected function getContent(): ?string
    {
        return $this->getContext()['content'];
    }
}