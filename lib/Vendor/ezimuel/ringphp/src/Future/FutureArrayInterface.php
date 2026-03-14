<?php

namespace OCA\FullTextSearch_OpenSearch\Vendor\GuzzleHttp\Ring\Future;

/**
 * Future that provides array-like access.
 */
interface FutureArrayInterface extends FutureInterface, \ArrayAccess, \Countable, \IteratorAggregate
{
}
