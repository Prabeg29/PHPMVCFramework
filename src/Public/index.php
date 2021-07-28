<?php

define('APP_ROOT', dirname(dirname(__DIR__)));

use app\Core\Router;
use app\Core\Application;
use app\Controllers\SiteController;
use app\Controllers\AuthController;

require_once APP_ROOT.'/vendor/autoload.php';

Router::get('/', [SiteController::class, 'home']);
Router::get('/contact', [SiteController::class, 'contact']);
Router::get('/login', [AuthController::class, 'login']);
Router::get('/register', [AuthController::class, 'register']);

Router::post('/contact', [SiteController::class, 'handleContact']);
Router::post('/login', [AuthController::class, 'login']);
Router::post('/register', [AuthController::class, 'register']);

$app = new Application(dirname(__DIR__));
$app->run();
