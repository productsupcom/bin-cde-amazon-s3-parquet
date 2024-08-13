<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Converter\ParquetFileConverter;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Importer;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Processor\Processor;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Transporter\Transporter;
use Productsup\DK\Connector\Application\Feed\OutputFeedForImport;
use Productsup\DK\Connector\Application\Logger\ConnectorFinished;
use Productsup\DK\Connector\Application\Logger\ConnectorLogger;
use Productsup\DK\Connector\Application\Logger\ConnectorStarted;

class ImporterTest extends TestCase
{
    private $transporter;
    private $logger;
    private $outputFeedForImport;
    private $processor;
    private $converter;
    private $importer;

    protected function setUp(): void
    {
        $this->transporter = $this->createMock(Transporter::class);
        $this->logger = $this->createMock(ConnectorLogger::class);
        $this->outputFeedForImport = $this->createMock(OutputFeedForImport::class);
        $this->processor = $this->createMock(Processor::class);
        $this->converter = $this->createMock(ParquetFileConverter::class);

        $this->importer = new Importer(
            $this->transporter,
            $this->logger,
            $this->outputFeedForImport,
            $this->processor,
            $this->converter
        );
    }

    public function testImportProcessIsSuccessful(): void
    {
        $this->logger->expects($this->once())
            ->method('info')
            ->with($this->equalTo(ConnectorStarted::fromName(Importer::NAME)));

        $this->transporter->expects($this->once())
            ->method('transport');

        $this->converter->expects($this->once())
            ->method('convert');

        $this->processor->expects($this->once())
            ->method('processFile')
            ->willReturn((function () {
                yield ['row1'];
                yield ['row2'];
            })());

        $this->outputFeedForImport->expects($this->exactly(2))
            ->method('appendToOutputFeed');

        $this->outputFeedForImport->expects($this->once())
            ->method('end');

        $this->logger->expects($this->once())
            ->method('success')
            ->with($this->equalTo(ConnectorFinished::fromName(Importer::NAME)));

        $this->importer->import();
    }

    public function testImportProcessWithNoRows(): void
    {
        $this->logger->expects($this->once())
            ->method('info')
            ->with($this->equalTo(ConnectorStarted::fromName(Importer::NAME)));

        $this->transporter->expects($this->once())
            ->method('transport');

        $this->converter->expects($this->once())
            ->method('convert');

        $this->processor->expects($this->once())
            ->method('processFile')
            ->willReturn((function () {
                yield from [];
            })());

        $this->outputFeedForImport->expects($this->never())
            ->method('appendToOutputFeed');

        $this->outputFeedForImport->expects($this->once())
            ->method('end');

        $this->logger->expects($this->once())
            ->method('success')
            ->with($this->equalTo(ConnectorFinished::fromName(Importer::NAME)));

        $this->importer->import();
    }
}
