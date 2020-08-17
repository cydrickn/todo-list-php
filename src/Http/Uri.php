<?php

namespace Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    private string $scheme;
    private string $host;
    private int $port;
    private ?string $user;
    private ?string $pass;
    private string $path;
    private string $fragment;
    private array $query;

    public function __construct(string $uri)
    {
        $uriParts = parse_url($uri);
        $this->scheme = $uriParts['scheme'] ?? 'http';
        $this->host = $uriParts['host'] ?? 'localhost';
        $this->port = (int) $uriParts['port'] ?? 80;
        $this->user = $uriParts['user'] ?? null;
        $this->pass = $uriParts['pass'] ?? null;
        $this->path = $uriParts['path'] ?? '/';
        $this->fragment = $uriParts['fragment'] ?? '';
        $query = [];
        parse_str($uriParts['query'] ?? '', $query);
        $this->query = $query;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        // TODO: Implement getAuthority() method.
    }

    public function getUserInfo()
    {
        // TODO: Implement getUserInfo() method.
    }

    public function getHost()
    {
        // TODO: Implement getHost() method.
    }

    public function getPort()
    {
        // TODO: Implement getPort() method.
    }

    public function getPath()
    {
        // TODO: Implement getPath() method.
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getFragment()
    {
        // TODO: Implement getFragment() method.
    }

    public function withScheme($scheme)
    {
        // TODO: Implement withScheme() method.
    }

    public function withUserInfo($user, $password = null)
    {
        // TODO: Implement withUserInfo() method.
    }

    public function withHost($host)
    {
        // TODO: Implement withHost() method.
    }

    public function withPort($port)
    {
        // TODO: Implement withPort() method.
    }

    public function withPath($path)
    {
        // TODO: Implement withPath() method.
    }

    public function withQuery($query)
    {
        // TODO: Implement withQuery() method.
    }

    public function withFragment($fragment)
    {
        // TODO: Implement withFragment() method.
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}