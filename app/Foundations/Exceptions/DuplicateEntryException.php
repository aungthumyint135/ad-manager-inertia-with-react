<?php

namespace App\Foundations\Exceptions;

use Exception;

class DuplicateEntryException extends Exception
{
    protected $code = 409;
}
