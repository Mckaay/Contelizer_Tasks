<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator;

use ContelizerTasks\PESELValidator\Contracts\Validator;
use ContelizerTasks\PESELValidator\Enums\DigitWage;
use ContelizerTasks\PESELValidator\Traits\PESELHelper;
use DateTimeImmutable;

final readonly class PESELValidator implements Validator
{
    use PESELHelper;

    public function validate(string $PESELNumber): bool
    {
        return
            $this->checkIfIsNumeric($PESELNumber)
            && $this->checkIfIsCorrectLength($PESELNumber)
            && $this->checkControlSum($PESELNumber)
            && $this->checkDate($PESELNumber);
    }

    private function checkIfIsNumeric(string $PESELNumber): bool
    {
        return is_numeric($PESELNumber);
    }

    private function checkIfIsCorrectLength(string $PESELNumber): bool
    {
        return strlen($PESELNumber) === 11;
    }

    private function checkControlSum(string $PESELNumber): bool
    {
        $wages = DigitWage::cases();
        $sum = 0;

        $index = 0;
        foreach ($wages as $wage) {
            $sum += $wage->wage() * (int) $PESELNumber[$index];
            $index++;
        }

        $lastDigit = 10 - ($sum % 10) === 10 ? 0 : 10 - ($sum % 10);

        return $lastDigit === (int) $PESELNumber[10];
    }

    private function checkDate(string $PESELNumber): bool
    {
        $year = $this->getYearOfBirth($PESELNumber);
        $month = $this->getMonthOfBirth($PESELNumber);
        $day = $this->getDayOfBirth($PESELNumber);

        if ($year === '0' || $month === '0' || $day === '0') {
            return false;
        }

        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d', "$year-$month-$day");
        if (! $dateTime) {
            return false;
        }

        $currentDate = new DateTimeImmutable;
        if ($currentDate < $dateTime) {
            return false;
        }

        return true;
    }
}
