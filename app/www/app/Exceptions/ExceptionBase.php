<?php

namespace App\Exceptions;

use App\Http\Controllers\ControllerBase;
use Exception;

class ExceptionBase extends Exception
{
    public function render($request)
    {
        return ControllerBase::sendError($this->getMessage(), $this->getCode());
    }
}
