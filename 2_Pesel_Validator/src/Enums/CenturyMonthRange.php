<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Enums;

enum CenturyMonthRange: int
{
    case NINETEEN_CENTURY_MONTH_MIN = 81;
    case NINETEEN_CENTURY_MONTH_MAX = 92;

    case TWENTY_CENTURY_MONTH_MIN = 1;
    case TWENTY_CENTURY_MONTH_MAX = 12;

    case TWENTY_ONE_CENTURY_MONTH_MIN = 21;
    case TWENTY_ONE_CENTURY_MONTH_MAX = 32;

    case TWENTY_TWO_CENTURY_MONTH_MIN = 41;
    case TWENTY_TWO_CENTURY_MONTH_MAX = 52;

    case TWENTY_THREE_CENTURY_MONTH_MIN = 61;
    case TWENTY_THREE_CENTURY_MONTH_MAX = 72;

    public static function getCenturyBasedOnMonthValue(int $monthValue): Century|bool
    {
        if ($monthValue >= self::NINETEEN_CENTURY_MONTH_MIN->value && $monthValue <= self::NINETEEN_CENTURY_MONTH_MAX->value) {
            return Century::NINETEEN;
        }

        if ($monthValue >= self::TWENTY_CENTURY_MONTH_MIN->value && $monthValue <= self::TWENTY_CENTURY_MONTH_MAX->value) {
            return Century::TWENTY;
        }

        if ($monthValue >= self::TWENTY_ONE_CENTURY_MONTH_MIN->value && $monthValue <= self::TWENTY_ONE_CENTURY_MONTH_MAX->value) {
            return Century::TWENTY_ONE;
        }

        if ($monthValue >= self::TWENTY_TWO_CENTURY_MONTH_MIN->value && $monthValue <= self::TWENTY_TWO_CENTURY_MONTH_MAX->value) {
            return Century::TWENTY_TWO;
        }

        if ($monthValue >= self::TWENTY_THREE_CENTURY_MONTH_MIN->value && $monthValue <= self::TWENTY_THREE_CENTURY_MONTH_MAX->value) {
            return Century::TWENTY_THREE;
        }

        return false;
    }
}
