<?php

namespace App\Exceptions\Import\Coordinates;

use Exception;

class InvalidFieldsException extends Exception
{
    protected $message = 'Invalid fields provided. Allowed fields are: latitude, longitude';
}
