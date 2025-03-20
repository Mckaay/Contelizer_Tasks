<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Support;

use InvalidArgumentException;

final class TextFilesFinder
{
    public static function find(string $directoryPath): array|bool
    {
        if (! is_dir($directoryPath)) {
            return throw new InvalidArgumentException("Directory {$directoryPath} does not exist");
        }

        $allFiles = array_diff(scandir($directoryPath, SCANDIR_SORT_DESCENDING), ['..', '.']);
        $textFiles = array_filter($allFiles, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'txt';
        });

        if (empty($textFiles)) {
            return throw new InvalidArgumentException("There are no text files in data/input directory}. Please add some");
        }

        return $textFiles;
    }
}
