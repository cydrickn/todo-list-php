<?php

namespace Http;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{
    use MessageTrait;

    public const HTTP_CODE_OK = 200;
    public const HTTP_CODE_CREATED = 201;
    public const HTTP_CODE_BAD_REQUEST = 400;
    public const HTTP_CODE_NOT_FOUND = 404;
    // TODO: add all status codes

    private const REASON_PHRASES = [
        Response::HTTP_CODE_OK => 'Ok',
        Response::HTTP_CODE_CREATED => 'Created',
        Response::HTTP_CODE_BAD_REQUEST => 'Bad Request',
        Response::HTTP_CODE_NOT_FOUND => 'Not Found',
        // TODO: add all status code reason phrases
    ];

    private int $code;

    public function __construct(int $code, $body = null, array $headers = [], string $version = '1.1')
    {
        $this->code = $code;
        $this->setBody($body);
        $this->setHeaders(array_merge($this->getDefaultHeaders(), $headers));
        $this->protocol = $version;
    }

    private function getDefaultHeaders(): array
    {
        return ['Content-Type' => 'text/html'];
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = ''): self
    {
        if (!is_int($code)) {
            throw new InvalidArgumentException('Argument 1 must be integer only');
        }

        if ($this->code === $code) {
            return $this;
        }

        $clone = clone $this;
        $clone->code = $code;

        return $clone;
    }

    public function getReasonPhrase(): string
    {
        return self::REASON_PHRASES[$this->code] ?? '';
    }
}
