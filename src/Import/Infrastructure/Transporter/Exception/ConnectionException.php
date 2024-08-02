<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Exception;

use Productsup\DK\Connector\Exception\Core\ClientLevelException;
use Throwable;

final class ConnectionException extends ClientLevelException
{
    public static function dueToPrevious(Throwable $previous): self
    {
        return new self(
            message: $previous->getMessage(),
            previous: $previous
        );
    }
}
