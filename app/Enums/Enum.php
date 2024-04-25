<?php

namespace App\Enums;

abstract class Enum
{
    protected static $constants = [];

    public static function getConstants(): array
    {
        $rClass = new \ReflectionClass(static::class);

        return $rClass->getConstants();
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, static::getConstants());
    }

    public static function getValues(): array
    {
        return array_values(static::getConstants());
    }
}
