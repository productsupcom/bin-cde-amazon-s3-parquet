<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application;

use Productsup\BinCdeAmazonS3Parquet\Import\Application\Converter\ParquetFileConverter;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Processor\Processor;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Transporter\Transporter;
use Productsup\DK\Connector\Application\Feed\OutputFeedForImport;
use Productsup\DK\Connector\Application\Logger\ConnectorFinished;
use Productsup\DK\Connector\Application\Logger\ConnectorLogger;
use Productsup\DK\Connector\Application\Logger\ConnectorStarted;

final readonly class Importer
{
    public const NAME = 'Amazon S3 Parquet Importer';

    public function __construct(
        private Transporter $transporter,
        private ConnectorLogger $logger,
        private OutputFeedForImport $outputFeedForImport,
        private Processor $processor,
        private ParquetFileConverter $converter
    ) {
    }

    public function import(): void
    {
        $this->logger->info(ConnectorStarted::fromName(self::NAME));
        $this->transporter->transport();
        $this->converter->convert();
        foreach ($this->processor->processFile() as $row) {
            $this->outputFeedForImport->appendToOutputFeed($row);
        }
        $this->outputFeedForImport->end();
        $this->logger->success(ConnectorFinished::fromName(self::NAME));
    }
}
