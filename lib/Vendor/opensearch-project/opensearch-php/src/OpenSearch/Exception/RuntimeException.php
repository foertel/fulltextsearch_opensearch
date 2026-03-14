<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Common\Exceptions\OpenSearchException;
/**
 * An exception thrown when a runtime error occurs.
 *
 * @phpstan-ignore class.implementsDeprecatedInterface
 */
class RuntimeException extends \RuntimeException implements OpenSearchException
{
}
