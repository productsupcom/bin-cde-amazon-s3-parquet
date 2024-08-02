<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Factory;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;

final class FilesystemFactory
{
    public static function make(FilesystemAdapter $adapter): Filesystem
    {
        return new Filesystem($adapter);
    }
}
