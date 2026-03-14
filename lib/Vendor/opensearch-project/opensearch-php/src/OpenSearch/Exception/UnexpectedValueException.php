<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Exception;

use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Common\Exceptions\OpenSearchException;
/**
 * An exception thrown when invalid arguments are passed to a method.
 *
 * @phpstan-ignore class.implementsDeprecatedInterface
 */
class UnexpectedValueException extends \UnexpectedValueException implements OpenSearchException
{
}
