<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

/**
 * Exception thrown when a 500 Internal Server Error HTTP error occurs for No Shard Available.
 */
class NoShardAvailableException extends InternalServerErrorHttpException
{
}
