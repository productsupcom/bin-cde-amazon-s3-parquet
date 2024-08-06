<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Application\Transporter;

interface Transporter
{
    public function transport(): void;
}
