<?php

namespace App\Foundations\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    protected $code = 401;

    protected $message = 'Unauthorized';
}
