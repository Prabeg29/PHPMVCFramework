<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Request;
use app\Models\RegisterModel;

class AuthController extends Controller {
    public function login (){
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request) {
        $registerModel = new RegisterModel();
        if($request->isPost()){
            $registerModel->loadData($request->getBody());
            if($registerModel->validate() && $registerModel->register()){
                return 'Success';
            }
            var_dump($registerModel->errors);
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }
}