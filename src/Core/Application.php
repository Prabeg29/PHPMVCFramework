<?php

namespace app\Core;

class Application {

    public static string $APP_ROOT;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct($appRoot)
    {
        self::$APP_ROOT = $appRoot;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(){
        echo $this->router->resolve();
    }
}