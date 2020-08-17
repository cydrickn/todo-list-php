<?php

namespace Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;

trait MessageTrait
{
    protected string $version;
    protected array $headers;
    protected ?string $body;

    public function getProtocolVersion(): string
    {
        return $this->version;
    }

    public function withProtocolVersion($version)
    {
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader($name): bool
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name): string
    {
        return $this->headers[$name];
    }

    public function getHeaderLine($name): string
    {
        return $name . ': ' . $this->headers[$name];
    }

    public function withHeader($name, $value)
    {
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }
}