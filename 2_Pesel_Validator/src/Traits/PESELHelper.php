<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Traits;

use ContelizerTasks\PESELValidator\Enums\CenturyMonthRange;

trait PESELHelper
{
    public function getYearOfBirth(string $PESELNumber): string
    {
        $yearValue = (int) substr($PESELNumber, 0, 2);
        $monthValue = (int) substr($PESELNumber, 2, 2);
        $century = CenturyMonthRange::getCenturyBasedOnMonthValue($monthValue);

        if (! $century) {
            return '0';
        }

        return (string) ($century->getStartYear() + $yearValue);
    }

    public function getMonthOfBirth(string $PESELNumber): string
    {
        $monthValue = (int) substr($PESELNumber, 2, 2);
        $century = CenturyMonthRange::getCenturyBasedOnMonthValue($monthValue);

        if (! $century) {
            return '0';
        }

        return (string) ($monthValue - $century->getCenturyMonthWage());
    }

    public function getDayOfBirth(string $PESELNumber): string
    {
        return substr($PESELNumber, 4, 2);
    }
}
