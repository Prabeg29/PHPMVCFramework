<?php

namespace app\Models;

use app\Core\Application;
use app\Core\Model;

class LoginForm extends Model{
    public string $email = '';
    public string $password = '';

    public function validationRules(): array {
        return [
            'email' => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL, 
                [
                    self::RULE_MIN,
                    'min'=>1
                ], 
                [
                    self::RULE_MAX, 
                    'max'=>255
                ]
            ],
            'password' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>8
                ],
                [
                    self::RULE_MAX,
                    'max'=>16
                ]
            ]
        ];
    }

    public function labels(): array {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function login() {
        $user = User::findOne(['email'=> $this->email]);
        if(!$user){
            $this->addError('email', 'User with the email does not exist');
            return false;
        }
        if(!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        return Application::$app->login($user);
    }
}