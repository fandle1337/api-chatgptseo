<?php

namespace App\Service;


use App\Exceptions\ExceptionBase;
use App\Models\Client;
use App\Models\ClientTokenUsage;
use App\Repository\RepositoryClient;
use App\Repository\RepositoryClientTokenUsage;
use App\Repository\RepositoryOrder;

class ServiceClientLimit
{
    public function __construct(
        protected Client                     $modelClient,
        protected ClientTokenUsage           $modelClientTokenUsage,
        protected RepositoryClientTokenUsage $repositoryClientTokenUsage,
        protected RepositoryClient           $repositoryClient,
        protected RepositoryOrder            $repositoryOrder,
    )
    {
    }

    /**
     * @throws ExceptionBase
     */
    public function isAllowUsage(string $clientLicenseHash): bool
    {
        return $this->getCountUsageLimit($clientLicenseHash) < $this->getClientLimit($clientLicenseHash);
    }

    protected function getClientLimit(string $clientLicenseHash): int
    {
        $clientId = $this->repositoryClient->getByHash($clientLicenseHash)->id;

        return $this->repositoryOrder->getTotalByClientId($clientId);
    }

    protected function getCountUsageLimit(string $clientLicenseHash): int
    {
        $clientId = $this->repositoryClient->getByHash($clientLicenseHash)->id;

        if (!$clientId) {
            return 0;
        }

        return $this->repositoryClientTokenUsage->getTotalByClientId($clientId);
    }


}
