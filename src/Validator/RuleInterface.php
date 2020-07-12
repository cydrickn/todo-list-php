<?php

namespace Validator;

interface RuleInterface
{
    public function validate($value): bool;

    public function getMessage($replacer): string;
}
