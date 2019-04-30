<?php


namespace Model;


interface ViewInterface
{
    public function setView(string $v): void;

    public function setTemplate(string $t): void;

    public function addModal(string $modal): void;

    public function assign(string $key, string $value): void;
}