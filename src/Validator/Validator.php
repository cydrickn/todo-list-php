<?php

namespace Validator;

class Validator
{
    /**
     * @var RuleInterface[]|array
     */
    private array $rules;
    private string $message;
    private bool $isValid;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
        $this->message = '';
        $this->isValid = false;
    }

    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    public function validate($value, $replacer)
    {
        foreach ($this->rules as $rule) {
            $this->isValid = $rule->validate($value);
            if (!$this->isValid) {
                $this->message = $rule->getMessage($replacer);
                break;
            }
        }
    }

    public function failed(): bool
    {
        return !$this->isValid;
    }

    public function passed(): bool
    {
        return $this->isValid;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}