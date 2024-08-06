<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Converter;

use Productsup\BinCdeAmazonS3Parquet\Import\Application\DuckDb\ParquetFileConverter as ParquetFileConverterInterface;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\DuckDb\Exception\FailedQueryExecutionException;

final readonly class ParquetFileConverter implements ParquetFileConverterInterface
{
    public function __construct(private string $tempFilename)
    {
    }

    public function convert(): void
    {
        $query = sprintf('duckdb -jsonlines -c "SELECT * FROM %s" > out.json', escapeshellarg($this->tempFilename));
        $output = exec($query, $output, $resultCode);

        if (0 !== $resultCode) {
            throw FailedQueryExecutionException::dueToQueryError();
        }
    }
}
