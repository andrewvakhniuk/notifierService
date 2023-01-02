<?php

namespace App\Service\Notifier\Notification;

use App\Core\Enum\LocaleEnum;

interface LocaleAwareInterface
{
    public function setLocale(LocaleEnum $locale): void;
    public function getLocale(): LocaleEnum;
}