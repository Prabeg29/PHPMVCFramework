<?php

namespace app\Core;

use app\Core\Middlewares\BaseMiddleware;

abstract class Controller {
    public string $layout = 'main';
    public string $action = '';
    /*
     * @var  \app\Core\Middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->view->view($view, $params);
    }    
    public function registerMiddleware(BaseMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array {
        return $this->middlewares;
    }
}