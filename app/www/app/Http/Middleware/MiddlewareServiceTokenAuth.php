<?php

namespace App\Http\Middleware;

use App\Exceptions\ExceptionBase;
use App\Helper\HelperBitrixKey;
use App\Models\ServiceTokenAuth;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareServiceTokenAuth
{

    public function __construct(
        protected ServiceTokenAuth $serviceTokenAuth
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
            'token' => 'required|max:255'
        ]);

        if($validator->fails()) {
            throw new ExceptionBase($validator->getMessageBag()->first(), 403);
        }

        if(!$this->serviceTokenAuth->where("token", $request->get("token"))->first()) {
            throw new ExceptionBase("Авторизация не пройдена", 403);
        }

        return $next($request);
    }
}
