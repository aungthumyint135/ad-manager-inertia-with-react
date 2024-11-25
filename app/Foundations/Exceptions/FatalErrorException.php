<?php

namespace App\Foundations\Exceptions;

use Exception;

class FatalErrorException extends Exception
{
    protected $message = 'Internal server error, Please try again later.';
}
