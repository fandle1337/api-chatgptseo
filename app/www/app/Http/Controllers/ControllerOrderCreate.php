<?php

namespace App\Http\Controllers;


use App\Exceptions\ExceptionBase;
use App\Helper\HelperBitrixKey;
use App\Http\Requests\RequestOrderCreate;
use App\Models\Product;
use App\Models\Transaction;
use App\Service\Payment\PaymentProviderYookassa;
use Carbon\Carbon;

class ControllerOrderCreate extends ControllerBase
{
    public function __construct(
        protected Transaction $transaction,
        protected Product $product,
        protected PaymentProviderYookassa $paymentProviderYookassa
    ) {
    }

    /**
     * @throws ExceptionBase
     */
    public function __invoke(RequestOrderCreate $request): \Illuminate\Http\JsonResponse
    {
        $clientLicenseHash = HelperBitrixKey::toHash($request->validated("license_key"));

        if(!$modelProduct = $this->product->where("id", $request->validated("product_id"))->first()) {
            throw new ExceptionBase("Product not found", 404);
        }

        $url = $this->paymentProviderYookassa->get(
            "41001254081693",
            $hash = md5(microtime()),
            $modelProduct->price,
            route("order.payment.receiver")
        );

        if(!is_string($url)) {
            throw new ExceptionBase("Provider payment not available", 500);
        }

        $this->transaction->create([
            "hash" => $hash,
            "client_license_hash" => $clientLicenseHash,
            "product_id" => $request->validated("product_id"),
            "created_at" => Carbon::createFromTimestamp(time())
        ]);

        return self::sendResponse($url);
    }
}
