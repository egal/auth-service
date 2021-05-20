<?php

namespace App\Exceptions;

use Egal\Exception\AuthException;

class ServiceNotFoundAuthException extends AuthException
{

    const BASE_MESSAGE_LINE = 'Service not found!';

}
