<?php
declare(strict_types=1);

namespace Entity;

use Model\UserInterface;
use Model\UsersRepository;
use ValueObject\Identity;

class Users implements UserInterface
{
    public $id = null;
    public $email;
    public $pwd;
    public $role = 1;
    public $status = 0;
    private $userRepository;
    private $identity;

    public function __construct(UsersRepository $usersRepository, Identity $identity)
    {
        $this->userRepository=$usersRepository;
        $this->identity=$identity;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
        $this->userRepository->getOneBy(['id' => $id], true);
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function setPassword(string $pwd): void
    {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}
