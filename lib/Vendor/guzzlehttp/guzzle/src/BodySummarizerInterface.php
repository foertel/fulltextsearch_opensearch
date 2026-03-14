<?php

namespace OCA\FullTextSearch_OpenSearch\Vendor\GuzzleHttp;

use OCA\FullTextSearch_OpenSearch\Vendor\Psr\Http\Message\MessageInterface;
interface BodySummarizerInterface
{
    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message): ?string;
}
