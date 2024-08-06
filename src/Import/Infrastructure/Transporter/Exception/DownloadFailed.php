<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Exception;

use Productsup\DK\Connector\Exception\Core\EngineeringLevelException;
use Throwable;

final class DownloadFailed extends EngineeringLevelException
{
    public static function dueToPrevious(Throwable $exception): self
    {
        return new self(
            message: 'Download failed.',
            previous: $exception
        );
    }
}
