<?php

namespace App\Factory;


use App\Actions\Action;
use DI\Container;

class ActionFactory
{
    public static function create(string $action, Container $container): Action
    {
        $action = 'App\\Actions\\' . ucfirst($action) . 'Action';

        return $container->get($action);
    }
}
