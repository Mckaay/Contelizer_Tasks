<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Contracts;

interface TransformationStrategy
{
    public static function transform(string $string): string;
}
