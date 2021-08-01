<?php

namespace app\Models;

use app\Core\DbModel;

class User extends DbModel{
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function validationRules(): array {
        return [
            'firstName' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>1
                ], 
                [
                    self::RULE_MAX,
                    'max'=>255
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
                    'max'=>255
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
                    'max'=>255
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
                    'max'=>16
                ]
            ],
            'confirmPassword' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>8
                ],
                [
                    self::RULE_MAX,
                    'max'=>16
                ],
                [
                    self::RULE_MATCH, 
                    'match'=>'password'
                ]
            ]
        ];
    }

    public function tableName(): string {
        return 'users';
    }

    public function columns(): array {
        return [
            'firstName',
            'lastName',
            'email',
            'password'
        ];
    }

    public function register() {
        return $this->save();
    }
}