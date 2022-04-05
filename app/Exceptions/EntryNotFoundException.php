<?php

namespace App\Exceptions;

use App\Http\Resources\GlobalResource;
use Illuminate\Http\Request;

class EntryNotFoundException extends BaseException
{
    private $errors;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function render(Request $request)
    {
        if($this->isApiRoute($request)) {
            return GlobalResource::jsonResponse(['resp' => __('db.notFound'), $this->errors], 422);
        }
    }
}