<?php

function validateTodo(string $title, string $description): array
{
    $errors = [];
    if (!validateBetweenLength($title, 4, 16)) {
        $errors['title'] = 'Title length should be between 4 and 12.';
    }
    if (!validateMinimumLength($description, 15)) {
        $errors['description'] = 'Description length should be greater than or equal to 15.';
    }

    return $errors;
}

function validateMinimumLength(string $value, int $minLength): bool
{
    return strlen($value) >= $minLength;
}

function validateMaximumLength(string $value, int $maxLength): bool
{
    return strlen($value) <= $maxLength;
}

function validateBetweenLength(string $value, int $minLength, int $maxLength): bool
{
    return validateMinimumLength($value, $minLength) && validateMaximumLength($value, $maxLength);
}