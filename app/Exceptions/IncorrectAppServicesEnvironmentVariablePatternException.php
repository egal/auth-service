<?php

namespace App\Exceptions;

use Exception;

class IncorrectAppServicesEnvironmentVariablePatternException extends Exception
{

    protected $code = 500;
    protected $message = 'Incorrect app services environment variable pattern!';

    public static function make(string $string): self
    {
        $result = new static();
        $result->message .= ' [' . $string . ']';

        return $result;
    }

}
