<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Transporter\Factory;

use AsyncAws\SimpleS3\SimpleS3Client;
use League\Flysystem\AsyncAwsS3\AsyncAwsS3Adapter;
use League\Flysystem\FilesystemAdapter;

final class S3AdapterFactory
{
    public static function make(SimpleS3Client $client, string $bucket): FilesystemAdapter
    {
        return new AsyncAwsS3Adapter(
            $client,
            $bucket
        );
    }
}
