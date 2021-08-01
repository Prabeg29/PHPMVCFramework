<?php

namespace app\Core;

class Session {
    public const FLASH_MESSAGES = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach($flashMessages as $key => &$flashMessage) {
            $flashMessage['isRemoved'] = true;
        }
        $_SESSION[self::FLASH_MESSAGES] = $flashMessages;
    }

    public function setFlashMessage($key, $message) {
        $_SESSION[self::FLASH_MESSAGES][$key] = [
            'isRemoved' => false,
            'value' => $message
        ];
        var_dump($_SESSION[self::FLASH_MESSAGES]);
    }

    public function getFlashMessage($key) {
        var_dump($_SESSION[self::FLASH_MESSAGES][$key]['value']); // ?? false;
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_MESSAGES] ?? [];
        foreach($flashMessages as $key => &$flashMessage) {
            if($flashMessage['isRemoved']){
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_MESSAGES] = $flashMessages;
    }
}