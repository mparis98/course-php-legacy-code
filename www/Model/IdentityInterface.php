<?php


namespace Model;


interface IdentityInterface
{
    public function setLastname(string $lastname): void;

    public function setFirstname(string $firstname): void;

    public function getLastname(): string;

    public function getFirstname(): string;
}