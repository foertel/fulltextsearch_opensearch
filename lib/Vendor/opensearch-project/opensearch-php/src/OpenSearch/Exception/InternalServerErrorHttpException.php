<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

/**
 * Exception thrown when a 500 Internal Server Error HTTP error occurs.
 */
class InternalServerErrorHttpException extends HttpException
{
    public function __construct(string $message = '', array $headers = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(500, $message, $headers, $code, $previous);
    }
}
