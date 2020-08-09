<?php

namespace View;

interface ViewInterface
{
    public function render(array $data): string;
}