<?php

declare(strict_types=1);

namespace Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Processor;

use Generator;
use JsonException;
use Productsup\BinCdeAmazonS3Parquet\Import\Application\Processor\Processor;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Processor\Exception\FileOpenFailException;
use Productsup\DK\Connector\Exception\JsonParsingFailed;

final class JsonProcessor implements Processor
{
    public function processFile(): Generator
    {
        $fp = @fopen('out.json', 'r');
        if (false === $fp) {
            throw FileOpenFailException::dueToFailedOpen();
        }
        while (($buffer = fgets($fp)) !== false) {
            try {
                yield json_decode(json: $buffer, associative: true, flags: JSON_THROW_ON_ERROR, );
            } catch (JsonException $e) {
                throw JsonParsingFailed::dueToPrevious($e);
            }
        }

        fclose($fp);
    }
}
