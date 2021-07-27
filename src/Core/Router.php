<?php

namespace app\Core;

class Router {
    private static array $routes = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
            echo "Callback does not exist";
        }

        echo call_user_func($callback);
    }
}