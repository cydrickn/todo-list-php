<?php

namespace Http;

use InvalidArgumentException;
use RuntimeException;
use Psr\Http\Message\StreamInterface;
use Throwable;

class Stream implements StreamInterface
{
    private const READ_WRITE_MODE = [
        'read' => ['r', 'r+', 'w+', 'a+', 'x+', 'c+'],
        'write' => ['w', 'r+', 'w+', 'a', 'a+', 'x', 'x+', 'c', 'c+'],
    ];

    /** @var resource|null */
    private $stream;
    private ?int $size;
    private bool $seekable;
    private bool $writable;
    private bool $readable;

    public function __construct($body = null)
    {
        if (!is_string($body) && !is_resource($body) && $body === null) {
            throw new InvalidArgumentException('Argument 1 must be string, resource or null');
        }
        
        if (is_string($body)) {
            $resource = fopen('php://temp', 'w+');
            fwrite($resource, $body);
            $body = $resource;
        }

        $this->stream = $body;
        if ($this->isSeekable()) {
            fseek($body, 0, SEEK_CUR);
        }
    }

    public function __toString()
    {
        try {
            if ($this->isSeekable()) {
                $this->rewind();
            }

            return $this->getContents();
        } catch (Throwable $exception) {
            return '';
        }
    }

    public function close(): void
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        $this->detach();
    }

    /**
     * @return resource|null
     */
    public function detach()
    {
        $resource = $this->stream;
        unset($this->stream);

        return $resource;
    }

    public function getSize(): ?int
    {
        if ($this->size !== null) {
            return $this->size;
        }

        if ($this->stream === null) {
            return null;
        }

        $stats = fstat($this->stream);
        $this->size = $stats['size'] ?? null;

        return $this->size;
    }

    public function tell(): int
    {
        if ($this->stream === null) {
            throw new RuntimeException('Unable to get current position');
        }

        $position = ftell($this->stream);
        if ($position === false) {
            throw new RuntimeException('Unable to get current position');
        }

        return $position;
    }

    public function eof(): bool
    {
        return $this->stream !== null && feof($this->stream);
    }

    public function isSeekable(): bool
    {
        if ($this->seekable === null) {
            $this->seekable = $this->getMetadata('seekable') ?? false;
        }

        return $this->seekable;
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        if (!$this->isSeekable()) {
            throw new RuntimeException('Stream is not seekable');
        }

        if (fseek($this->stream, $offset, $whence) === -1) {
            throw new RuntimeException('Unable to seek stream position ' . $offset);
        }
    }

    public function rewind(): void
    {
        $this->seek(0);
    }

    public function isWritable(): bool
    {
        if (!is_resource($this->stream)) {
            return false;
        }

        if ($this->writable === null) {
            $mode = $this->getMetadata('mode');
            $this->writable = in_array($mode, self::READ_WRITE_MODE['write']);
        }

        return $this->writable;
    }

    public function write($string): int
    {
        if (!$this->isWritable()) {
            throw new RuntimeException('Stream is not writable');
        }
        $result = fwrite($this->stream, $string);
        if ($result === false) {
            throw new RuntimeException('Unable to write to stream');
        }

        return $result;
    }

    public function isReadable()
    {
        if (!is_resource($this->stream)) {
            return false;
        }

        if ($this->readable === null) {
            $mode = $this->getMetadata('mode');
            $this->readable = in_array($mode, self::READ_WRITE_MODE['read']);
        }

        return $this->readable;
    }

    public function read($length): string
    {
        if (!$this->isReadable()) {
            throw new RuntimeException('Stream is not readable');
        }
        $result = fread($this->stream, $length);
        if ($result === false) {
            throw new RuntimeException('Unable to read the stream');
        }

        return $result;
    }

    public function getContents(): string
    {
        if (!is_resource($this->stream)) {
            throw new RuntimeException('Unable to read stream contents');
        }

        $contents = stream_get_contents($this->stream);
        if ($contents === false) {
            throw new RuntimeException('Unable to read stream contents');
        }

        return $contents;
    }

    public function getMetadata($key = null)
    {
        if ($this->stream === null) {
            return $key === null ? null : [];
        }

        $meta = stream_get_meta_data($this->stream);
        if ($key === null) {
            return $meta;
        }

        return $meta[$key] ?? null;
    }
}