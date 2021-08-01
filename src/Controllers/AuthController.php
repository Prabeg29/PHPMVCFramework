<?php

namespace app\Controllers;

use app\Core\Application;
use app\Core\Controller;
use app\Core\Request;
use app\Core\Response;
use app\Models\User;

class AuthController extends Controller {
    public function login (){
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request, Response $response) {
        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());
            if($user->validate() && $user->save()){
                Application::$app->session->setFlashMessage('Success', 'Thank you for registering');
                Application::$app->session->getFlashMessage('Success');
                $response->redirect('/');
            }
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }
}