<?php

namespace App\Command;

use App\Service\CommissionCalculatorService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Exception\ExceptionInterface;

class ProcessFileCommand extends Command
{
    public function __construct(
        private readonly CommissionCalculatorService $commissionCalculatorService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:process-file')
            ->setDescription('Processes a TXT file with currency data')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to the TXT file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath');

        try {
            $commissions = $this->commissionCalculatorService->calculate($filePath);

            foreach ($commissions as $commission) {
                $output->writeln(sprintf('Commission: %f', $commission));
            }

            return Command::SUCCESS;

        } catch (ExceptionInterface $e) {
            $output->writeln(sprintf('<error>Error: %s</error>', $e->getMessage()));
            return Command::FAILURE;
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Unexpected Error: %s</error>', $e->getMessage()));
            return Command::FAILURE;
        }
    }
}
