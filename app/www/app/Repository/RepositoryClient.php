<?php

namespace app\Repository;

use App\Dto\DtoClient;
use App\Models\Client;

class RepositoryClient
{
    public function getByHash(string $clientHash): DtoClient|bool
    {
        $model = Client::where('client_license_hash', $clientHash)->first();
        if (!$model) {
            return false;
        }

        return DtoClient::createByModel($model);
    }

    public function create(string $domain, string $clientLicenseHash, string $tariffCode): int|bool
    {
        $client = Client::create([
            'domain'              => $domain,
            "client_license_hash" => $clientLicenseHash,
            'tariff_code'         => $tariffCode,
        ]);
        return $client?->id ?? false;
    }

    public function update(DtoClient $dtoClient): bool
    {
        $model = Client::where('id', $dtoClient->id)
            ->first();

        if (!$model) {
            return false;
        }

        return !!$model->update([
                'domain'              => $dtoClient->domain,
                "client_license_hash" => $dtoClient->licenseHash,
                'tariff_code'         => $dtoClient->tariffCode,
            ]);
    }
}
