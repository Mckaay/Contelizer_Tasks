<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Tests;

use ContelizerTasks\PESELValidator\PESELValidator;
use PHPUnit\Framework\TestCase;

final class PESELValidationTest extends TestCase
{
    private array $correctNumbers = [
        '57063077975',
        '90020938959',
        '53122966792',
        '55102085468',
        '93030728794',
        '52121034631',
        '79032753684',
        '44051401458',
        '03222165793',
    ];

    private array $incorrectNumbers = [
        '12345678901',
        '99999999999',
        '00000000000',
        '01234567890',
        '12345678901',
        '-03222165793',
    ];

    public function test_correct_numbers(): void
    {
        $peselValidator = new PESELValidator;

        foreach ($this->correctNumbers as $number) {
            $this->assertTrue($peselValidator->validate($number));
        }
    }

    public function test_incorrect_numbers(): void
    {
        $peselValidator = new PESELValidator;

        foreach ($this->incorrectNumbers as $number) {
            $this->assertFalse($peselValidator->validate($number));
        }
    }
}
