<?php

namespace Validator;

class LengthRule implements RuleInterface
{
    public ?int $max;
    public ?int $min;

    public function __construct(?int $min = null, ?int $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate($value): bool
    {
        if ($this->min !== null && $this->max !== null) {
            return strlen($value) >= $this->min && strlen($value) <= $this->max;
        } elseif ($this->max === null) {
            return strlen($value) >= $this->min;
        } elseif ($this->min === null) {
            return strlen($value) <= $this->max;
        }
    }

    public function getMessage($replacer): string
    {
        if ($this->min !== null && $this->max !== null) {
            return sprintf('%s length should be between %d and %s.', $replacer, $this->min, $this->max);
        } elseif ($this->max === null) {
            return sprintf('%s length should be greater than or equal to %d', $replacer, $this->min);
        } elseif ($this->min === null) {
            return sprintf('%s length should be less than or equal to %d', $replacer, $this->max);
        }
    }
}