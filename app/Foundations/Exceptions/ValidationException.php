<?php

namespace App\Foundations\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $code = 400;
}
