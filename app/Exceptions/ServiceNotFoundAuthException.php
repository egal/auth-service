<?php

namespace App\Exceptions;

use Exception;

class ServiceNotFoundAuthException extends Exception
{

    protected $message = 'Service not found!';
    protected $code = 400;

}
