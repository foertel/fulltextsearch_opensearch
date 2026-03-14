<?php

declare (strict_types=1);
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\HttpClient;

use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Client;
use OCA\FullTextSearch_OpenSearch\Vendor\Psr\Log\LoggerInterface;
use OCA\FullTextSearch_OpenSearch\Vendor\Symfony\Component\HttpClient\HttpClient;
use OCA\FullTextSearch_OpenSearch\Vendor\Symfony\Component\HttpClient\Psr18Client;
use OCA\FullTextSearch_OpenSearch\Vendor\Symfony\Component\HttpClient\RetryableHttpClient;
/**
 * Builds an OpenSearch client using Symfony.
 */
class SymfonyHttpClientFactory implements HttpClientFactoryInterface
{
    public function __construct(protected int $maxRetries = 0, protected ?LoggerInterface $logger = null)
    {
    }
    /**
     * {@inheritdoc}
     */
    public function create(array $options): Psr18Client
    {
        if (!isset($options['base_uri'])) {
            throw new \InvalidArgumentException('The base_uri option is required.');
        }
        // Set default configuration.
        $defaults = ['headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json', 'User-Agent' => sprintf('opensearch-php/%s (%s; PHP %s)', Client::VERSION, \PHP_OS, \PHP_VERSION)]];
        $options = array_merge_recursive($defaults, $options);
        $symfonyClient = HttpClient::create()->withOptions($options);
        if ($this->maxRetries > 0) {
            $symfonyClient = new RetryableHttpClient($symfonyClient, null, $this->maxRetries, $this->logger);
        }
        return new Psr18Client($symfonyClient);
    }
}
