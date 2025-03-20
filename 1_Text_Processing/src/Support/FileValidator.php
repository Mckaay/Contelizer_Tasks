<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Support;

use InvalidArgumentException;
use SplFileObject;

final class FileValidator
{
    public static function validate(string $path): SplFileObject
    {
        $file = new SplFileObject($path);

        if ($file->isReadable() === false) {
            throw new InvalidArgumentException("File {$path} is not readable");
        }

        if ($file->getSize() === 0) {
            throw new InvalidArgumentException("This File is empty");
        }

        return $file;
    }
}
