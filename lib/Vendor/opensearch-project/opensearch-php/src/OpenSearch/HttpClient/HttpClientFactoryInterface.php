<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\HttpClient;

use OCA\FullTextSearch_OpenSearch\Vendor\Psr\Http\Client\ClientInterface;
/**
 * Interface for OpenSearch client factories.
 */
interface HttpClientFactoryInterface
{
    /**
     * Build the OpenSearch client.
     *
     * @param array<string,mixed> $options
     */
    public function create(array $options): ClientInterface;
}
