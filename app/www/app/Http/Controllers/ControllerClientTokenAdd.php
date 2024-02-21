<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionBase;
use App\Helper\HelperBitrixKey;
use App\Http\Requests\RequestClientInfo;
use App\Http\Requests\RequestClientTokenAdd;
use App\Models\ClientTokenLimit;
use App\Models\Product;
use App\Service\ServiceClientLimit;

class ControllerClientTokenAdd extends ControllerBase
{
    public function __construct(
        protected ClientTokenLimit $clientTokenLimit
    ){
    }

    /**
     * @throws ExceptionBase
     */
    public function __invoke(RequestClientTokenAdd $request): \Illuminate\Http\JsonResponse
    {
        $modelClientTokenLimit = $this->clientTokenLimit
            ->where("client_license_hash", $request->validated("client_license_hash"))
            ->first();

        if(!$modelClientTokenLimit) {
            throw new ExceptionBase("Client not found", 404);
        }

        $r = $modelClientTokenLimit->update([
            "limit" => $modelClientTokenLimit->limit + $request->validated("value")
        ]);

        return self::sendResponse($r);
    }
}
