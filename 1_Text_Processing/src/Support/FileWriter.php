<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Support;

use SplFileObject;

final readonly class FileWriter
{
    public function __construct(private string $fileName) {}

    public function write(string $content): void
    {
        $newFile = new SplFileObject((OUTPUT_DIRECTORY.$this->fileName.'.txt'), 'w');
        $newFile->fwrite($content);
    }
}
