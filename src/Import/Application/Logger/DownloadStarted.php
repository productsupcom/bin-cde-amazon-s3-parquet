<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application\Logger;

use Stringable;

final readonly class DownloadStarted implements Stringable
{
    private function __construct(private string $filename)
    {
    }

    public static function fromName(string $filename): self
    {
        return new self($filename);
    }

    public function __toString(): string
    {
        return "The download of the file {$this->filename} has started.";
    }
}
