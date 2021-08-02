<?php

namespace app\Core;

use app\Models\User;

class Application {

    public static string $SRC;
    public static Application $app;

    public string $className;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public Controller $controller;
    public ?User $user = null;

    public function __construct($src, array $config)
    {
        self::$app = $this;
        self::$SRC = $src;
       
        $this->db = new Database($config['db']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->className = $config['className'];

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = $this->className::primaryKey();
            $this->user = $this->className::findOne([$primaryKey => $primaryValue]);
        }
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

    public function login(User $user) {
        $this->user = $user;
        $primaryKey = $this->user->primaryKey();
        $primaryValue = $this->user->{$primaryKey};
        $this->session->set('user', $primaryValue);

        return true;
    }

    public function logout () {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest() {
        return !self::$app->user;
    }
}