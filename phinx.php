<?php

use DI\Container;
use Slim\Factory\AppFactory;

require_once './vendor/autoload.php';
require_once './src/settings.php';
require_once './database/generator/BaseMigration.php';
require_once './database/BaseSeeder.php';

// Create Container using PHP-DI
$container = new Container();

// Set container to create App with on AppFactory
AppFactory::setContainer($container);

$app = AppFactory::create();
$dbServices = (new \App\Services\AsteriskDBServices());
$dbServices->register($container);


return [
    'paths'                => [
        'migrations' => 'database/migrations',
        'seeds'      => 'database/seeds',
    ],
    'migration_base_class' => 'BaseMigration',
    'templates'            => [
        'class' => 'TemplateGenerator',
    ],
    'aliases'              => [
        'create' => 'CreateTableTemplateGenerator',
    ],

    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database'        => 'development',
        'development'             => [
            'name'       => $dbServices->getDatabase(),
            'connection' => $container->get('db')->getConnection()->getPdo(),
        ],
        'production'              => [
            'adapter'   => 'mysql',
            'host'      => $dbServices->getHost(),
            'name'      => $dbServices->getDatabase(),
            'user'      => $dbServices->getUser(),
            'pass'      => $dbServices->getPass(),
            'port'      => $dbServices->getPort(),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],
];
