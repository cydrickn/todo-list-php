<?php

namespace Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    use MessageTrait;

    private int $code;
    private string $reasonPhrase;

    public function __construct(string $body = '', int $code = 200, array $headers = [], string $reasonPhrase = '')
    {
        $defaultHeaders = [
            'Content-Type' => 'text/html',
        ];
        $this->headers = array_merge($defaultHeaders, $headers);
        $this->body = $body;
        $this->code = $code;
        $this->reasonPhrase = $reasonPhrase;
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
         return new Response($this->body, $code, $this->headers, $reasonPhrase);
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    public function render()
    {
        foreach ($this->headers as $header => $value) {
            header($header . ': ' . $value);
        }

        return $this->body;
    }
}