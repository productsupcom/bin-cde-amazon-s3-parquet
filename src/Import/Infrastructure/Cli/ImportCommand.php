<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Cli;

use Productsup\BinCdeAmazonS3Parquet\Import\Application\Importer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'import',
    description: 'Sample import command',
    aliases: ['import'],
    hidden: false
)]
final class ImportCommand extends Command
{
    public function __construct(
        private readonly Importer $importer,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->importer->import();

        return Command::SUCCESS;
    }
}
