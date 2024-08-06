<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application\Converter;

interface ParquetFileConverter
{
    public function convert(): void;
}
