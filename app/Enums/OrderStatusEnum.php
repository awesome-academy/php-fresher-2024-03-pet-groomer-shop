<?php

namespace App\Enums;

class OrderStatusEnum extends Enum
{
    public const CREATED = 0;
    public const CONFIRMED = 1;
    public const IN_PROGRESS = 2;
    public const WAITING = 3;
    public const COMPLETED = 4;
    public const CANCELLED = 5;

    public static function getTranslated(): array
    {
        $arrFlip = array_flip(static::getConstants());
        $arrFlip[0] = __('order.created');
        $arrFlip[1] = __('order.confirmed');
        $arrFlip[2] = __('order.in_progress');
        $arrFlip[3] = __('order.waiting');
        $arrFlip[4] = __('order.completed');

        return $arrFlip;
    }
}
