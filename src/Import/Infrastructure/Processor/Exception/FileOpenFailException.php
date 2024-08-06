<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Processor\Exception;

use Productsup\DK\Connector\Exception\Core\EngineeringLevelException;

final class FileOpenFailException extends EngineeringLevelException
{
    public static function dueToFailedOpen(): self
    {
        return new self('Failed to open file to process.');
    }
}
