<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Core\Request;
use app\Models\User;

class AuthController extends Controller {
    public function login (){
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request) {
        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());
            if($user->validate() && $user->register()){
                return 'Success';
            }
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }
}