<?php

namespace App\Http\Controllers;

use App\Enum\EnumClientTariff;
use App\Exceptions\ExceptionBase;
use App\Http\Requests\RequestClientActivate;
use App\Http\Response\Response;
use App\Repository\RepositoryClient;
use App\Repository\RepositoryTariffs;
use App\Service\Api\HttpClientBus;
use Illuminate\Http\JsonResponse;

class ControllerClientActivate extends ControllerBase
{
    public function __construct(
        protected HttpClientBus $httpClientBus,
        protected RepositoryTariffs $repositoryTariffs,
        protected RepositoryClient $repositoryClient,
    ) {
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ExceptionBase
     */
    public function __invoke(RequestClientActivate $request): JsonResponse
    {
        if(!$dtoClient = $this->repositoryClient->getByHash($request->validated("clientKeyHash"))) {
            return Response::json("Client not found", 404);
        }

        if($dtoClient->tariffCode == EnumClientTariff::REAL->name) {
            return Response::json("Client activated", 403);
        }

        return Response::json($this->repositoryClient->update($dtoClient));
    }
}
