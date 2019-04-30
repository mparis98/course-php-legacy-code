<?php


namespace Model;


interface UserInterface
{
    public function setId(int $id): void;

    public function setEmail(string $email): void;

    public function setPassword(string $password): void;

    public function setRole(string $role): void;

    public function setStatus(string $status): void;
}