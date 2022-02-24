<?php

namespace App\Exceptions;

use Exception;
use App\Http\Resources\GlobalResource;

class ValidationErrorException extends Exception
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render()
    {
        return GlobalResource::jsonResponse(['resp' => __('validation.genericError'), $this->errors], 422);
    }
}
