<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Converter\Exception;

use Productsup\DK\Connector\Exception\Core\EngineeringLevelException;

final class FailedQueryExecutionException extends EngineeringLevelException
{
    public static function dueToQueryError(): self
    {
        return new self('Failed to execute query.');
    }
}
