<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Contracts;

interface Validator
{
    public function validate(string $PESELNumber): bool;
}
