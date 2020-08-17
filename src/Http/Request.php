<?php

namespace Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request implements RequestInterface
{
    use MessageTrait;

    private string $method;
    private UriInterface $uri;
    private array $post;

    public function __construct(
        string $method,
        $uri,
        array $headers = [],
        ?string $body = null,
        string $version = '1.1'
    ) {
        $this->method = $method;
        if (is_string($uri)) {
            $this->uri = new Uri($uri);
        } elseif ($uri instanceof UriInterface) {
            $this->uri = $uri;
        }
        $this->body = $body;
        $this->headers = $headers;
        $this->version = $version;
    }

    public function getRequestTarget()
    {
    }

    public function withRequestTarget($requestTarget)
    {
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function withMethod($method)
    {
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false): RequestInterface
    {
        return new Request($this->method, $uri, $this->headers, $this->body, $this->version);
    }

    public function getQuery(string $parameter, $default = null)
    {
        return $this->getUri()->getQuery()[$parameter] ?? $default;
    }

    public function getPost(string $parameter, $default = null)
    {
        return $this->post[$parameter] ?? $default;
    }

    public static function createFromGlobal(): RequestInterface
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $headers = headers_list();
        $contentType = $headers['Content-Type'];
        $formTypes = ['application/x-www-form-urlencoded', 'multipart/form-data'];
        $body = null;
        if (in_array($contentType, $formTypes)) {
            $body = file_get_contents('php://input');
        }
        $uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_ENV['HTTP_HOST']. $_SERVER['REQUEST_URI'];

        $request = new Request($method, $uri, $headers, $body);
        $request->post = $_POST;

        return $request;
    }
}