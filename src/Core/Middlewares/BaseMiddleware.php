<?php

namespace app\Core\Middlewares;

abstract class BaseMiddleware {
    abstract public function execute();
}