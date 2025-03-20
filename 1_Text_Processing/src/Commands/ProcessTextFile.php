<?php

declare(strict_types=1);

namespace ContelizerTasks\TextProcessing\Commands;

use ContelizerTasks\TextProcessing\Enums\TransformersMapper;
use ContelizerTasks\TextProcessing\Support\FileReader;
use ContelizerTasks\TextProcessing\Support\FileWriter;
use ContelizerTasks\TextProcessing\Support\TextFilesFinder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'process', description: 'Process and modify the text file with the specified text transformation strategy')]
final class ProcessTextFile extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $io->title('Process text from file and write it to another one with the specified text transformation strategy');

            $inputFileName = $this->getInputFileName($io);
            $newFileName = $this->getNewFileName($io);
            $selectedStrategy = TransformersMapper::tryFrom($this->selectTransformationStrategy($io))->strategy();

            $fileReader = new FileReader($inputFileName);
            $fileWriter = new FileWriter($newFileName);

            $modifiedContent = $selectedStrategy::transform($fileReader->read());
            $fileWriter->write($modifiedContent);

            $io->success(
                'Text file was successfully processed and saved to '.$newFileName.'.txt in output directory'
            );

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }
    }

    private function getInputFileName(SymfonyStyle $io): string
    {
        $availableTextFiles = TextFilesFinder::find(INPUT_DIRECTORY);

        return $io->choice('Please select file to process:', $availableTextFiles);
    }

    private function getNewFileName(SymfonyStyle $io): string
    {
        return $io->ask('Please enter the name of the output file without .txt extension');
    }

    private function selectTransformationStrategy(SymfonyStyle $io): string
    {
        return $io->choice('Please select text transformation strategy:', TransformersMapper::getValues());
    }
}
