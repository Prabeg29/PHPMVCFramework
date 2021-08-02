<?php

define('APP_ROOT', dirname(dirname(__DIR__)));
define('SRC', (dirname(__DIR__)));

use app\Core\Router;
use app\Core\Application;
use app\Controllers\SiteController;
use app\Controllers\AuthController;

require_once APP_ROOT.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

Router::get('/', [SiteController::class, 'home']);
Router::get('/contact', [SiteController::class, 'contact']);
Router::get('/login', [AuthController::class, 'login']);
Router::get('/register', [AuthController::class, 'register']);
Router::get('/logout', [AuthController::class, 'logout']);

Router::post('/contact', [SiteController::class, 'handleContact']);
Router::post('/login', [AuthController::class, 'login']);
Router::post('/register', [AuthController::class, 'register']);

$config = [
    'className' => \app\Models\User::class,
    'db' => [
        'dsn'=> $_ENV['DB_DSN'],
        'username'=> $_ENV['DB_USERNAME'],
        'password'=> $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(SRC, $config);
$app->run();
