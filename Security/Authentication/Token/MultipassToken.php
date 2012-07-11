<?php

namespace Polem\MultiPassBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

use MultiPass\AuthHash;

class MultipassToken extends AbstractToken
{
    protected $authHash;

    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }

    public function setAuthHash(AuthHash $authHash)
    {
        $this->authHash = $authHash;
    }

    public function getAuthHash()
    {
        return $this->authHash;
    }

    public function getUsername()
    {
        $this->authHash->uid();
    }
}

