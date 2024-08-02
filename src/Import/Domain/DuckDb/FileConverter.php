<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Domain\DuckDb;

interface FileConverter
{
    public function convert(): void;
}
