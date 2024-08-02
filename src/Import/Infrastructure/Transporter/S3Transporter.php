<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToWriteFile;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Logger\DownloadFinished;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Logger\DownloadStarted;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Transporter\Transporter;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Exception\DownloadFailed;
use Productsup\DK\Connector\Application\Logger\ConnectorLogger;

final class S3Transporter implements Transporter
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly ConnectorLogger $logger,
        private readonly string $filename,
        private readonly string $tempFilename
    ) {
    }

    public function transport(): void
    {
        $key = ltrim($this->filename, '/');
        $this->logger->info(DownloadStarted::fromName($this->filename));

        try {
            //read and save file as local copy
            $fileContent = $this->filesystem->read($key);
            file_put_contents($this->tempFilename, $fileContent);
        } catch (FilesystemException|UnableToWriteFile $exception) {
            throw DownloadFailed::dueToPrevious($exception);
        }
        $this->logger->info(DownloadFinished::fromName($this->filename));
    }
}
