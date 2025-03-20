<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Support;

use RuntimeException;
use SplFileObject;

final class FileReader
{
    private ?SplFileObject $file;

    public function __construct(string $fileName)
    {
        $this->file = FileValidator::validate(INPUT_DIRECTORY.$fileName);
    }

    public function read(): string
    {
        if ($this->file === null) {
            throw new RuntimeException('File not found');
        }

        return $this->file->fread($this->file->getSize());
    }
}
