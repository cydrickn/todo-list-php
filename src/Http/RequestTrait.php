<?php

namespace Http;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

trait RequestTrait
{
    protected array $validMethods = ['post', 'get', 'delete', 'put', 'patch', 'head', 'option'];
    protected string $requestTarget;
    protected string $method;
    protected UriInterface $uri;

    protected function setUri($uri): void
    {
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }
        $this->uri = $uri;
    }

    public function getRequestTarget(): string
    {
        return $this->requestTarget;
    }

    public function withRequestTarget($requestTarget): self
    {
        if ($this->requestTarget === $requestTarget) {
            return $this;
        }

        $clone = clone $this;
        $clone->requestTarget = $requestTarget;

        return $clone;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod($method): self
    {
        if ($this->method === $method) {
            return $this;
        }

        if (!in_array($method, $this->validMethods)) {
            throw new InvalidArgumentException('Only ' . implode(', ', self::VALID_METHODS) . ' are acceptable');
        }

        $clone = clone $this;
        $clone->method = strtolower($method);

        return $clone;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $clone = clone $this;

        if ($preserveHost) {
            $clone->uri = $uri->withHost($this->uri->getHost());
        } else {
            $clone->uri = $uri;
        }

        return $clone;
    }
}