<?php


namespace Model;


interface ViewInterface
{
    public function setView(string $view): void;

    public function setTemplate(string $template): void;

    public function addModal(string $modal,array $config): void;

    public function assign(string $key, array $value): void;
}