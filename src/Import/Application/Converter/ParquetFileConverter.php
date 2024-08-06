<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application\DuckDb;

interface ParquetFileConverter
{
    public function convert(): void;
}
