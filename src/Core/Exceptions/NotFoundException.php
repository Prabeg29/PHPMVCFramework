<?php

namespace app\Core\Exceptions;

use Exception;

class NotFoundException extends Exception{
    protected $message = "Page not found";
    protected $code = 404;
}