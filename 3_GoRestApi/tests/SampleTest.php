<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;

final class SampleTest extends TestCase
{
    public function test_if_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
