<?php

use Controller\PagesController;
use Controller\UsersController;
use Entity\Users;
use Core\BaseSQL;
use Model\UsersRepository;

return [
    BaseSQL::class => function ($container) {
        $host = $container['config']['database']['host'];
        $driver = $container['config']['database']['driver'];
        $name = $container['config']['database']['name'];
        $user = $container['config']['database']['user'];
        $password = $container['config']['database']['password'];

         $pdo = new BaseSQL($driver, $host, $name, $user, $password);
         return $pdo->getPdo();
    },
    Users::class => function ($container) {
        $baseSql = $container[BaseSQL::class]($container);
        $userRep = new UsersRepository($baseSql);

        return new Users($userRep);
    },
    UsersController::class => function ($container) {
        $userModel = $container[Users::class]($container);
        $baseSql = $container[BaseSQL::class]($container);
        $userRep = new UsersRepository($baseSql);
        return new UsersController($userModel, $userRep);
    },
    PagesController::class => function ($container) {
        return new PagesController();
    }
];