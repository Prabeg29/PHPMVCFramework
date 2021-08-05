<?php

namespace app\Models;

use app\Core\Model;

class ContactForm extends Model {
    public function validationRules(): array
    {
        return [
            'subject' => [
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
                ]
            ],
            'body' => [
                self::RULE_REQUIRED,
                [
                    self::RULE_MIN,
                    'min'=>1
                ],
                [
                    self::RULE_MAX,
                    'max'=>255
                ]
            ]
        ];
    }

    public function labels(): array {
        return [
            'subject' => 'Subject',
            'email' => 'Email',
            'body' => 'Body'
        ];
    }

    public function send() {
        return true;
    }
}