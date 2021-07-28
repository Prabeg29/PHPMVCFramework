<?php

namespace app\Core;

class Router {
    private static array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function get($url, $callback){
        self::$routes['get'][$url] = $callback;
    }

    public static function post($url, $callback){
        self::$routes['post'][$url] = $callback;
    }

    public function resolve(){
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();
        $callback = self::$routes[$method][$url] ?? false;

        if(!$callback){
            $this->response->setStatusCode(404);
            return $this->view("_404");
        }
        if(is_string($callback)){
            return $this->view($callback);
        }
        return call_user_func($callback);
    }

    public function view($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent =  $this->viewContent($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent() {
        ob_start();
        include_once Application::$APP_ROOT."/Views/Layouts/main.php";
        return ob_get_clean();
    }

    public function viewContent($view) {
        ob_start();
        include_once Application::$APP_ROOT."/Views/$view.php";
        return ob_get_clean();
    }
}