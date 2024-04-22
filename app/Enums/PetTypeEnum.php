<?php

namespace App\Enums;

class PetTypeEnum extends Enum
{
    public const CAT = 0;
    public const DOG = 1;
    public const HAMSTER = 2;
    public const BIRD = 3;
    public const OTHER = 4;

    public static function getTranslated(): array
    {
        $arrFlip = array_flip(static::getConstants());
        $arrFlip[0] = __('Cat');
        $arrFlip[1] = __('Dog');
        $arrFlip[2] = __('Hamster');
        $arrFlip[3] = __('Bird');
        $arrFlip[4] = __('Other');

        return $arrFlip;
    }
}
