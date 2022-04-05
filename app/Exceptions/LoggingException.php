<?php

namespace App\Exceptions;

use App\Http\Resources\GlobalResource;
use Illuminate\Http\Request;

class LoggingException extends BaseException
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render(Request $request)
    {
        if($this->isApiRoute($request)) {
            return GlobalResource::jsonResponse(['resp' => "A transação foi realizada, mas não registrada", 'data' => $this->errors], 500);
        }
    }
}
