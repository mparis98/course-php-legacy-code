<?php


namespace Model;


interface RoutingInterface
{
    public static function getRoute(string $slug): array;

    public static function getSlug(string $c, string $a): ?string;
}