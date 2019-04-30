<?php


namespace Model;


interface ViewInterface
{
    public function setView(string $v): void;

    public function setTemplate(string $t): void;

    public function addModal(string $modal,array $config): void;

    public function assign(string $key, array $value): void;
}