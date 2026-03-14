<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

/**
 * Interface for HTTP error exceptions.
 */
interface HttpExceptionInterface extends OpenSearchExceptionInterface
{
    /**
     * Returns the status code.
     */
    public function getStatusCode(): int;
    /**
     * Returns response headers.
     */
    public function getHeaders(): array;
}
