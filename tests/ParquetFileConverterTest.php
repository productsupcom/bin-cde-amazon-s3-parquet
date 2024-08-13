<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Converter\Exception\FailedQueryExecutionException;
use Productsup\BinCdeAmazonS3Parquet\Import\Infrastructure\Converter\ParquetFileConverter;

final class ParquetFileConverterTest extends TestCase
{
    public function testSuccessfulConversion(): void
    {
        $tempFilename = (__DIR__.'/fixtures/test.parquet');
        $converter = new ParquetFileConverter($tempFilename);
        $converter->convert();
        $this->assertEquals(file_get_contents(__DIR__.'/fixtures/expected.json'), file_get_contents('out.json'));
        unlink((__DIR__.'/../out.json'));
    }

    public function testFailedConversionDueToInvalidFile(): void
    {
        $tempFilename = '/invalid/path/to/file.parquet';
        $converter = new ParquetFileConverter($tempFilename);

        $this->expectException(FailedQueryExecutionException::class);

        $converter->convert();
    }
}
