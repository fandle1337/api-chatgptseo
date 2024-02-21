<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionBase;
use App\Http\Requests\RequestOrderCreate;

class ControllerOrderPaymentReceiver extends ControllerBase
{
    public function __construct() {}

    /**
     * @throws ExceptionBase
     */
    public function __invoke(RequestOrderCreate $request): \Illuminate\Http\JsonResponse
    {
        throw new ExceptionBase("method not available", 500);
    }
}
