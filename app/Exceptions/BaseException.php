<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class BaseException extends Exception
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    protected function isApiRoute(Request $request)
    {
        return $request->route()->getPrefix() === 'api';
    }
}
