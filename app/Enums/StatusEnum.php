<?php

namespace App\Enums;

class StatusEnum extends Enum
{
    public const INACTIVE = 0;
    public const ACTIVE = 1;

    public static function getTranslated(): array
    {
        $arrFlip = array_flip(static::getConstants());
        $arrFlip[0] = __('Inactive');
        $arrFlip[1] = __('Active');

        return $arrFlip;
    }
}
