<?php

declare(strict_types=1);

use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToWriteFile;
use PHPUnit\Framework\TestCase;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Exception\DownloadFailed;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\S3Transporter;
use Productsup\DK\Connector\Application\Logger\ConnectorLogger;

final class S3TransporterTest extends TestCase
{
    public function testSuccessfulFileTransport(): void
    {
        $filesystemOperator = $this->createMock(FilesystemOperator::class);
        $logger = $this->createMock(ConnectorLogger::class);
        $transporter = new S3Transporter($filesystemOperator, $logger, 'filename', 'tempFilename');

        $filesystemOperator->method('read')->willReturn('file content');

        $this->expectNotToPerformAssertions();

        $transporter->transport();
    }

    public function testFailedFileTransportDueToFilesystemException(): void
    {
        $filesystemOperator = $this->createMock(FilesystemOperator::class);
        $logger = $this->createMock(ConnectorLogger::class);
        $transporter = new S3Transporter($filesystemOperator, $logger, 'filename', 'tempFilename');

        $filesystemOperator->method('read')->willThrowException(new UnableToWriteFile('error message'));

        $this->expectException(DownloadFailed::class);

        $transporter->transport();
    }
}
