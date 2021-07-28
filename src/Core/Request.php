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

    public function isGet() {
        return $this->getMethod() === 'get';
    }

    public function isPost() {
        return $this->getMethod() === 'post';
    }

    public function getBody() {
        $body = [];
        if($this->isGet()){
            foreach($_GET as $key=>$value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        else if($this->isPost()){
            foreach($_POST as $key=>$value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}