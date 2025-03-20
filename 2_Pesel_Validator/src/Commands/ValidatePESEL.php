<?php

declare(strict_types=1);

namespace ContelizerTasks\PESELValidator\Commands;

use ContelizerTasks\PESELValidator\PESELValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(name: 'validate', description: 'PESEL number validator')]
final class ValidatePESEL extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $userInput = $this->getPESELFromUser($io);
            $peselValidator = new PESELValidator;

            if ($peselValidator->validate($userInput) === false) {
                $io->error('Invalid PESEL number');
                return Command::FAILURE;
            }

            $io->success('Valid PESEL number');
        } catch (Throwable $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function getPESELFromUser(SymfonyStyle $io): string
    {
        return trim($io->ask('Enter PESEL number'));
    }
}
