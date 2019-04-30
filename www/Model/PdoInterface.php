<?php


namespace Model;


interface PdoInterface
{
    public function getPdo(): \PDO;
}