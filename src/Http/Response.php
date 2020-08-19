<?php

namespace Http;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{
    use MessageTrait;

    private const REASON_PHRASES = [
        200 => 'Ok',
        201 => 'Created',
        400 => 'Bad Request',
        404 => 'Not Found',
        // TODO: add all status code reason phrases
    ];

    private int $code;

    public function __construct(int $code, $body = null, array $headers = [], string $version = '1.1')
    {
        $this->code = $code;
        $this->setBody($body);
        $this->setHeaders($headers);
        $this->protocol = $version;
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