<?php

namespace app\Models;

use app\Core\DB\UserModel;

class User extends UserModel{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;

    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public int $status = self::STATUS_INACTIVE;

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
                [
                    self::RULE_UNIQUE,
                    'class' => self::class
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

    public static function tableName(): string {
        return 'users';
    }

    public function columns(): array {
        return [
            'firstName',
            'lastName',
            'email',
            'password',
            'status'
        ];
    }

    public function primaryKey(): string {
        return "id";
    }

    public function save() {
        $this->status = self::STATUS_ACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function labels(): array {
        return [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password ',

        ];
    }

    public function getDisplayName(): string {
        return $this->firstName . ' ' . $this->lastName;
    }
}