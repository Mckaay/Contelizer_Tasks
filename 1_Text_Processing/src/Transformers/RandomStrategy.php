<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Transformers;

use ContelizerTasks\TextProcessing\Contracts\TransformationStrategy;

final class RandomStrategy implements TransformationStrategy
{
    public static function transform(string $string): string
    {
        return preg_replace_callback('/\b(\w{3,})\b/u', function ($matches) {
            $word = $matches[1];
            $firstChar = mb_substr($word, 0, 1, 'UTF-8');
            $lastChar = mb_substr($word, -1, 1, 'UTF-8');
            $middle = mb_substr($word, 1, mb_strlen($word, 'UTF-8') - 2, 'UTF-8');

            $middleArray = preg_split('//u', $middle, -1, PREG_SPLIT_NO_EMPTY);
            shuffle($middleArray);
            $shuffledMiddle = implode('', $middleArray);

            return $firstChar . $shuffledMiddle . $lastChar;
        }, $string);
    }
}
