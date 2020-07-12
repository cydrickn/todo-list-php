<?php

namespace Manager;

interface SessionDataProviderInterface
{
    public function getCurrentSession(): array;

    public function setCurrentSession(array $data): self;
}