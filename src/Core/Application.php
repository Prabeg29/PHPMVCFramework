<?php

namespace app\Core;

class Application {

    public static string $APP_ROOT;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public Controller $controller;

    public function __construct($appRoot, array $config)
    {
        self::$APP_ROOT = $appRoot;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    public function run(){
        echo $this->router->resolve();
    }

    public function getController() {
        return $this->controller;
    }

    public function setController(Controller $controller) {
        $this->controller = $controller;
    }
}