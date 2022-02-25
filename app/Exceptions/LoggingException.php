<?php

namespace App\Exceptions;

use Exception;
use App\Http\Resources\GlobalResource;

class LoggingException extends Exception
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render()
    {
        return GlobalResource::jsonResponse(['resp' => "A transação foi realizada, mas não registrada", 'data' => $this->errors], 500);
    }
}
