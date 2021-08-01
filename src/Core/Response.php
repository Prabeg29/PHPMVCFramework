<?php

namespace app\Core;

class Response {
    public function setStatusCode(int $statusCode) {
        http_response_code($statusCode);
    }

    public function redirect(string $url) {
        header("Location: $url");
    }
}