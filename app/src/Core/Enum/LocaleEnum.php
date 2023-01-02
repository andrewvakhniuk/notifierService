<?php

namespace App\Core\Enum;

enum LocaleEnum: string
{
    case EN = 'en';
    case UA = 'ua';

    public const DEFAULT = self::EN;
}
