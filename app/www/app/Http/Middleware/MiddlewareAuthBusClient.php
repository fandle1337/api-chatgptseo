<?php

namespace App\Http\Middleware;

use App\Exceptions\ExceptionBase;
use App\Models\ServiceTokenAuth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareAuthBusClient
{
    public function __construct(
        protected \App\Service\Api\HttpClientBus $httpClientBus
    )
    {
    }


    /**
     * @throws ExceptionBase
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ErrorException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|max:255',
            'module_code' => 'required|max:255',
        ]);

        if($validator->fails()) {
            throw new ExceptionBase($validator->getMessageBag()->first(), 403);
        }

        if(!$this->httpClientBus->isAuthWithCache($request->get("module_code"), $request->get("license_key"))) {
            throw new ExceptionBase("Client service api bus not found", 403);
        }


        return $next($request);
    }
}
