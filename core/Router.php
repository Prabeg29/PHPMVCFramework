<?php

namespace app\core;

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback){
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback){
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(){
        $method = $this->request->getMethod();
        $path =  $this->request->getPath();
        $callback = $this->routes[$method][$path] ?? false;

        if(!$callback){
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if(is_string($callback)){
            // View
            return $this->renderView($callback);
        }

        if(is_array($callback)){
            // Controller  + Action
            Application::$app->controller = new $callback[0];
            $callback[0] = Application::$app->controller;
            //$controller->action = $callback[1];
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderViewOnly($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent){
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent() {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";

        return ob_get_clean();
    }

    public function renderViewOnly($view, $params){

        foreach($params as $key=>$value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}