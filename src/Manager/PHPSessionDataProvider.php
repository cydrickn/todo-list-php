<?php

namespace Manager;

class PHPSessionDataProvider implements SessionDataProviderInterface
{
    public function getCurrentSession(): array
    {
        return $_SESSION;
    }

    public function setCurrentSession(array $data): SessionDataProviderInterface
    {
        $_SESSION = $data;

        return $this;
    }
}