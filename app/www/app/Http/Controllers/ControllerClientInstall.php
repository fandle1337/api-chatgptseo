<?php

namespace App\Http\Controllers;

use App\Dto\DtoOrder;
use App\Enum\EnumClientTariff;
use App\Enum\EnumOrderType;
use App\Exceptions\ExceptionBase;
use App\Helper\HelperBitrixKey;
use App\Http\Requests\RequestClientInstall;
use App\Http\Response\Response;
use App\Repository\RepositoryClient;
use App\Repository\RepositoryOrder;
use App\Repository\RepositoryTariffs;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ControllerClientInstall extends ControllerBase
{
    public function __construct(
        protected \App\Service\Api\HttpClientBus $httpClientBus,
        protected RepositoryClient               $repositoryClient,
        protected RepositoryTariffs              $repositoryTariffs,
        protected RepositoryOrder                $repositoryOrder,
    )
    {
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ExceptionBase
     */
    public function __invoke(RequestClientInstall $request): JsonResponse
    {
        $clientLicenseHash = HelperBitrixKey::toHash($request->validated("license_key"));

        if ($client = $this->repositoryClient->getByHash($clientLicenseHash)) {
            return Response::json($client->id);
        }

        $clientIsDemo = $this->httpClientBus->clientIsDemo(
            $request->validated("module_code"),
            $clientLicenseHash
        );

        $tariffCode = $clientIsDemo ? EnumClientTariff::DEMO->name : EnumClientTariff::REAL->name;

        $price = $this->repositoryTariffs
            ->getPriceByTariffCode($tariffCode);

        $clientId = $this->repositoryClient->create(
            $request->validated('domain'),
            $clientLicenseHash,
            $tariffCode
        );

        if (!$clientId) {
            return Response::json("Creating client error");
        }

        $dtoOrder = new DtoOrder(
            md5(microtime() . $clientId),
            $clientId,
            $price,
            Carbon::now()->format('Y-m-d H:i:s'),
            EnumOrderType::TYPE_PREINSTALL->name,
        );

        return Response::json(
            (bool)$this->repositoryOrder->create($dtoOrder)
        );
    }
}
