<?php

namespace app\Core;

class Request {
    public function getMethod() {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getUrl() {
        $url = $_SERVER["REQUEST_URI"] ?? '/';
        $startPosQueryParam = strpos($url, '?');

        if($startPosQueryParam){
            $url = substr($url, 0, $startPosQueryParam);
        }

        return $url;
    }
}