<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Enums;

enum Century
{
    case NINETEEN;
    case TWENTY;
    case TWENTY_ONE;
    case TWENTY_TWO;
    case TWENTY_THREE;

    public function getStartYear(): int
    {
        return match ($this) {
            self::NINETEEN => 1800,
            self::TWENTY => 1900,
            self::TWENTY_ONE => 2000,
            self::TWENTY_TWO => 2100,
            self::TWENTY_THREE => 2200,
        };
    }

    public function getCenturyMonthWage(): int
    {
        return match ($this) {
            self::NINETEEN => 80,
            self::TWENTY => 0,
            self::TWENTY_ONE => 20,
            self::TWENTY_TWO => 40,
            self::TWENTY_THREE => 60,
        };
    }
}
