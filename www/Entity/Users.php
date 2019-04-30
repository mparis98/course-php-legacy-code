<?php
declare(strict_types=1);

namespace Entity;

use Core\BaseSQL;
use Model\UsersRepository;

class Users
{
    public $id = null;
    public $firstname;
    public $lastname;
    public $email;
    public $pwd;
    public $role = 1;
    public $status = 0;
    private $repository;
    private $pdo;

    public function __construct($driver, $host, $name, $user, $password)
    {
        $this->repository = new UsersRepository($driver,$host,$name,$user,$password);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
        $this->repository->getOneBy(['id' => $id], true);
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email));
    }

    public function setPwd(string $pwd): void
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
