<?php

namespace Manager;

use Model\User;
use Service\UserDataProviderInterface;

class SessionManager
{
    private ?User $currentUser;
    private SessionDataProviderInterface $sessionDataProvider;
    private UserDataProviderInterface $userDataProvider;
    private string $loginedPage;

    public function __construct(
        SessionDataProviderInterface $sessionDataProvider,
        UserDataProviderInterface $userDataProvider,
        string $loginedPage
    ) {
        $this->sessionDataProvider = $sessionDataProvider;
        $this->userDataProvider = $userDataProvider;
        $this->currentUser = null;
        $this->loginedPage = $loginedPage;

        $this->initialize();
    }

    private function initialize()
    {
        $session = $this->sessionDataProvider->getCurrentSession();
        $isLogined = $session['logined'] ?? false;

        if ($isLogined) {
            $this->currentUser = $this->userDataProvider->findUserByUsername($session['username']);
        }
    }

    public function getCurrentUser(): ?User
    {
        return $this->currentUser;
    }

    public function setCurrentUser(?User $user): self
    {
        $this->currentUser = $user;
        if ($user !== null) {
            $this->sessionDataProvider->setCurrentSession(['logined' => true, 'username' => $user->getUsername()]);
        }

        return $this;
    }

    public function isLogined(): bool
    {
        return $this->currentUser instanceof User;
    }

    public function checkLoginedAndRedirect()
    {
        if (!$this->isLogined()) {
            header('Location:' . $this->loginedPage);
        }
    }
}