<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Transformers;

use ContelizerTasks\TextProcessing\Contracts\TransformationStrategy;

final class ReverseStrategy implements TransformationStrategy
{
    public static function transform(string $string): string
    {
        return preg_replace_callback('/\b(\w{3,})\b/u', function ($matches) {
            $word = $matches[1];

            $chars = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
            $reversedChars = array_reverse($chars);

            return implode('', $reversedChars);
        }, $string);
    }
}
