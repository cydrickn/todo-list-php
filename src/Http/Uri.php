<?php

namespace Http;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    private const SCHEME_PORTS = ['http' => 80, 'https' => 443];
    private const SUPPORTED_SCHEMES = ['http', 'https'];

    private string $scheme;
    private string $host;
    private ?int $port;
    private string $user;
    private ?string $password;
    private string $path;
    private string $query;
    private string $fragment;

    public function __construct(string $uri)
    {
        $uriParts = parse_url($uri);
        $this->scheme = $uriParts['scheme'];
        $this->host = strtolower($uriParts['host'] ?? 'localhost');
        $this->setPort($uriParts['port'] ?? null);
        $this->user = $uriParts['user'] ?? '';
        $this->password = $uriParts['password'] ?? null;
        $this->path = $uriParts['path'] ?? '';
        $this->query = $uriParts['query'] ?? '';
        $this->fragment = $uriParts['fragment'] ?? '';
    }

    private function setPort(?int $port): void
    {
        if (self::SCHEME_PORTS[$this->scheme] === $port) {
            $this->port = null;

            return;
        }

        $this->port = $port;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        $authority = $this->host;
        if ($this->getUserInfo() !== '') {
            $authority = $this->getUserInfo() . '@' . $this->host;
        }

        if ($this->getPort() !== null) {
            $authority .= ':' . $this->getPort();
        }

        return $authority;
    }

    public function getUserInfo(): string
    {
        $userInfo = $this->user;
        if ($this->password !== null && $this->password !== '') {
            $userInfo .= ':' . $this->password;
        }

        return $userInfo;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        $path = trim($this->path, '/'); // user = user

        return '/' . $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme($scheme): self
    {
        if ($this->scheme === $scheme) {
            return $this;
        }

        if (!in_array($scheme, self::SUPPORTED_SCHEMES)) {
            throw new InvalidArgumentException('Unsupported scheme');
        }

        $clone = clone $this;
        $clone->scheme = $scheme;

        return $clone;
    }

    public function withUserInfo($user, $password = null): self
    {
        $clone = clone $this;
        $clone->user = $user;
        $clone->password = $password;

        return $clone;
    }

    public function withHost($host): self
    {
        if (!is_string($host)) {
            throw new InvalidArgumentException('Invalid Host');
        }

        if (strtolower($host) === strtolower($this->host)) {
            return $this;
        }

        $clone = clone $this;
        $clone->host = strtolower($host);
        
        return $clone;
    }

    public function withPort($port): self
    {
        if ($port === $this->port) {
            return $this;
        }

        $clone = clone $this;
        $clone->setPort($port);

        return $clone;
    }

    public function withPath($path): self
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException('Invalid path');
        }

        if ($path === $this->path) {
            return $this;
        }

        $clone = clone $this;
        $clone->path = $path;

        return $clone;
    }

    public function withQuery($query): self
    {
        if (!is_string($query)) {
            throw new InvalidArgumentException('Invalid query');
        }

        if ($query === $this->query) {
            return $this;
        }

        $clone = clone $this;
        $clone->query = $query;

        return $clone;
    }

    public function withFragment($fragment): self
    {
        if ($fragment === $this->fragment) {
            return $this;
        }

        $clone = clone $this;
        $clone->fragment = $fragment;

        return $clone;
    }

    public function __toString()
    {
        $query = '';
        if ($this->query !== '') {
            $query = '?' . $this->query;
        }
        $fragment = '';
        if ($this->fragment !== '') {
            $fragment = '#' . $this->fragment;
        }

        return sprintf(
            '%s://%s%s%s%s',
            $this->getScheme(),
            $this->getAuthority(),
            $this->getPath(),
            $query,
            $fragment
        );
    }
}