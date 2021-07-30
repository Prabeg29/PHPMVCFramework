<?php

define('APP_ROOT', dirname(__DIR__));
define('SRC', __DIR__);

use app\Core\Application;

require_once APP_ROOT.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn'=> $_ENV['DB_DSN'],
        'username'=> $_ENV['DB_USERNAME'],
        'password'=> $_ENV['DB_PASSWORD'],
    ]
];
$app = new Application(SRC, $config);
$app->db->applyMigrations();