<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Enums;

enum DigitWage
{
    case FIRST;
    case SECOND;
    case THIRD;
    case FOURTH;
    case FIFTH;
    case SIXTH;
    case SEVENTH;
    case EIGHTH;
    case NINTH;
    case TENTH;

    public function wage(): int
    {
        return match ($this) {
            self::FIRST, self::FIFTH, self::NINTH => 1,
            self::SECOND, self::SIXTH, self::TENTH => 3,
            self::THIRD, self::SEVENTH => 7,
            self::FOURTH, self::EIGHTH => 9,
        };
    }
}
