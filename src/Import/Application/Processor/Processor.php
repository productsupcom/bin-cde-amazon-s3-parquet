<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application\Processor;

use Generator;

interface Processor
{
    public function processFile(): Generator;
}
