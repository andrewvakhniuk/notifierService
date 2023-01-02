<?php

namespace App\Service\Notifier\Message;


use App\Service\Notifier\Notification\LocaleAwareInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

interface TranslatableInterface extends LocaleAwareInterface
{
    public function translateMe(TranslatorInterface $translator): void;
}