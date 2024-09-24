<?php

declare(strict_types=1);

namespace PocketShares\Shared\Utilities;

class MoneyParser
{
    public static function floatToInt(float $number): int
    {
        $numberAsString = (string)$number;
        $precision = \explode('.', $numberAsString);
        if (isset($precision[1])) {
            $count = \strlen($precision[1]);
            return (int)(string)($numberAsString * (10 ** $count));
        }

        return (int)$numberAsString;
    }

    public static function stringToInt(string $number): int
    {
        $number = \trim($number);
        $number = \str_replace(['.', ',','0.', '0,'], '', $number);

        return (int)$number;
    }
}