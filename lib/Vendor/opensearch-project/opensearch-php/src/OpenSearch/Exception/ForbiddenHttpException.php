<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

/**
 * Exception thrown when a 403 Forbidden HTTP error occurs.
 */
class ForbiddenHttpException extends HttpException
{
    public function __construct(string $message = '', array $headers = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(403, $message, $headers, $code, $previous);
    }
}
