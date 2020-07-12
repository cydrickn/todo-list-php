<?php

class Authentication
{
    private $userDirectory;

    public function __construct(string $userDirectory)
    {
        $this->userDirectory = $userDirectory;
    }

    public function login(string $username, string $password): array
    {
        $result = $this->validateLogin($username, $password);
        if ($result['valid']) {
            $_SESSION['logined'] = true;
            $_SESSION['user'] = $this->getUserByUsername($username);
        }

        return $result;
    }

    public function getUserByUsername(string $username): ?array
    {
        $filepath = $this->userDirectory . '/' . $username . '.json';
        if (file_exists($filepath)) {
            $user = file_get_contents($filepath);

            return json_decode($user, true);
        } else {
            return null;
        }
    }

    public function validateLogin(string $username, string $password): array
    {
        $user = $this->getUserByUsername($username);
        if ($user === null) {
            return ['message' => 'Username does not exists.', 'valid' => false];
        } elseif ($user['password'] !== $password) {
            return ['message' => 'Password incorrect.', 'valid' => false];
        }

        return ['valid' => true];
    }
}