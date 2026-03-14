<?php

namespace OCA\FullTextSearch_OpenSearch\Vendor\Http\Discovery\Strategy;

use OCA\FullTextSearch_OpenSearch\Vendor\Http\Client\HttpAsyncClient;
use OCA\FullTextSearch_OpenSearch\Vendor\Http\Client\HttpClient;
use Http\Mock\Client as Mock;
/**
 * Find the Mock client.
 *
 * @author Sam Rapaport <me@samrapdev.com>
 */
final class MockClientStrategy implements DiscoveryStrategy
{
    public static function getCandidates($type)
    {
        if (is_a(HttpClient::class, $type, \true) || is_a(HttpAsyncClient::class, $type, \true)) {
            return [['class' => Mock::class, 'condition' => Mock::class]];
        }
        return [];
    }
}
