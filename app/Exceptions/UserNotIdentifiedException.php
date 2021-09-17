<?php

namespace App\Exceptions;

use Exception;

class UserNotIdentifiedException extends Exception
{

    protected $code = 400;
    protected $message = 'User not identified!';

}
