<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\DuckDb;

use Productsup\BinCdeAmazonS3Parquet\Import\Domain\DuckDb\FileConverter;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\DuckDb\Exception\FailedQueryExecutionException;

final readonly class ParquetFileConverter implements FileConverter
{
    public function __construct(private string $tempFilename)
    {
    }

    public function convert(): void
    {
        $query = sprintf("duckdb -jsonlines -c \"SELECT * FROM '%s'\" > out.json", $this->tempFilename);
        $output = exec($query, $output, $resultCode);

        if (0 !== $resultCode) {
            throw FailedQueryExecutionException::dueToQueryError();
        }
    }
}
