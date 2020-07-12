<?php

namespace Exceptions;

use Exception;
use Throwable;

class InvalidTodoException extends Exception
{
    private array $errors;

    public function __construct(array $errors, $code = 0, Throwable $previous = null)
    {
        parent::__construct('Invalid Todo', $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}