<?php

namespace app\Models;

use app\Core\Model;

class RegisterModel extends Model{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public string $confirmPassword;

    public function register() {
        echo "Creating new user";
    }

    public function validationRules(): array {
        return [
            'firstName' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>1
                ], 
                [
                    self::RULE_MAX, 'min'=>255
                ]
            ],
            'lastName' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>1
                ],
                [
                    self::RULE_MAX,
                    'min'=>255
                ]
            ],
            'email' => [
                self::RULE_REQUIRED, 
                self::RULE_EMAIL, 
                [
                    self::RULE_MIN,
                    'min'=>1
                ], 
                [
                    self::RULE_MAX, 
                    'min'=>255
                ], 
                self::RULE_UNIQUE
            ],
            'password' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>8
                ],
                [
                    self::RULE_MAX,
                    'min'=>16
                ]
            ],
            'confrimPassword' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>8
                ],
                [
                    self::RULE_MAX,
                    'min'=>16
                ],
                [
                    self::RULE_MATCH, 
                    'match'=>'password'
                ]
            ]
        ];
    }
}