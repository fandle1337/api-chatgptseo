<?php

namespace app\Service;

use App\Repository\RepositoryClient;
use App\Repository\RepositoryClientTokenUsage;
use App\Repository\RepositoryOrder;

class ServiceClientBalance
{
    public function __construct(
        protected RepositoryOrder $repositoryOrder,
        protected RepositoryClient $repositoryClient,
        protected RepositoryClientTokenUsage $repositoryClientTokenUsage,
    )
    {
    }

    public function countCurrentBalance(int $clientId): float
    {
        $totalPaid = $this->repositoryOrder->getTotalByClientId($clientId);
        $totalSpent = $this->repositoryClientTokenUsage->getTotalByClientId($clientId);

        return round($totalPaid - $totalSpent, 2);
    }
}
