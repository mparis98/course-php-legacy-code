<?php
declare(strict_types=1);

namespace ValueObject;

use Model\IdentityInterface;

class Identity implements IdentityInterface
{
    public $firstname;
    public $lastname;

    public function __construct()
    {
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

}