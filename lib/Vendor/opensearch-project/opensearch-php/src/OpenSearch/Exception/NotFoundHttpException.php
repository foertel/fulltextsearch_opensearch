<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

/**
 * Exception thrown when a 404 Not Found HTTP error occurs.
 */
class NotFoundHttpException extends HttpException
{
    public function __construct(string $message = '', array $headers = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(404, $message, $headers, $code, $previous);
    }
}
