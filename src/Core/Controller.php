<?php

namespace app\Core;

abstract class Controller {
    public string $layout = 'main';
    public function setLayout($layout){
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->router->view($view, $params);
    }    
}