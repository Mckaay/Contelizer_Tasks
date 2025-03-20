<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Enums;

use ContelizerTasks\TextProcessing\Transformers\RandomStrategy;
use ContelizerTasks\TextProcessing\Transformers\ReverseStrategy;

enum TransformersMapper: string
{
    case RANDOM = 'Random';
    case REVERSE = 'Reverse';

    public static function getValues(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $array[] = $case->value;
        }

        return $array;
    }

    public function strategy(): string
    {
        return match ($this) {
            self::RANDOM => RandomStrategy::class,
            self::REVERSE => ReverseStrategy::class,
        };
    }
}
