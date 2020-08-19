<?php

namespace Http;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request implements RequestInterface
{
    use MessageTrait;
    use RequestTrait;

    public function __construct(string $method, $uri, array $headers = [], $body = null, string $version = '1.1')
    {
        $this->method = strtolower($method);
        $this->protocol = $version;
        $this->setUri($uri);
        $this->setHeaders($headers);
        $this->setBody($body);
    }
}