<?php

namespace App\Http\Controllers;

use App\Helper\HelperBitrixKey;
use App\Http\Requests\RequestClientInfo;
use App\Http\Resources\ResourceModelText;
use App\Http\Resources\ResourceOrder;
use App\Http\Response\Response;
use App\Repository\RepositoryClient;
use App\Repository\RepositoryClientTokenUsage;
use App\Repository\RepositoryGptModel;
use app\Repository\RepositoryOrder;
use App\Service\ServiceClientBalance;
use Illuminate\Http\JsonResponse;

class ControllerClientInfo extends ControllerBase
{
    public function __construct(
        protected ServiceClientBalance       $serviceClientBalance,
        protected RepositoryClientTokenUsage $repositoryClientTokenUsage,
        protected RepositoryClient           $repositoryClient,
        protected RepositoryGptModel         $repositoryGptModel,
        protected RepositoryOrder            $repositoryOrder,
    )
    {
    }

    public function __invoke(RequestClientInfo $request): JsonResponse
    {
        $clientLicenseHash = HelperBitrixKey::toHash($request->validated("license_key"));
        $clientId = $this->repositoryClient->getByHash($clientLicenseHash)->id;

        return Response::json([
            "balance"         => $this->serviceClientBalance->countCurrentBalance($clientId),
            "statistics"      => [
                'usages_by_task' => $this->repositoryClientTokenUsage->getTaskStatsByClientId($clientId),
                'usages_by_model' => $this->repositoryClientTokenUsage->getModelStatsByClientId($clientId),
                'usages_by_month' => $this->repositoryClientTokenUsage->getMouthStatsByClientId($clientId),
            ],
            'payment_history' => ResourceOrder::collection($this->repositoryOrder->getStatsByClientId($clientId)),
            "model_options"   => ResourceModelText::collection($this->repositoryGptModel->getActive()),
        ]);
    }
}
