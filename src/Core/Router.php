<?php

namespace app\Core;

use app\Core\Exceptions\NotFoundException;

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
            throw new NotFoundException();
        }
        if(is_string($callback)){ // View File
            return Application::$app->view->view($callback);
        }
        if(is_array($callback)){
            /* *
             * @var \app\Core|Controller $controller
             */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}