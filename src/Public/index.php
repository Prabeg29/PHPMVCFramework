<?php

define('APP_ROOT', dirname(dirname(__DIR__)));

use app\Core\Application;
use app\Core\Router;

require_once APP_ROOT.'/vendor/autoload.php';

Router::get('/', 'home');
Router::get('/contact', 'contact');

$app = new Application(dirname(__DIR__));
$app->run();
