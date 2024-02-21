<?php

namespace app\Dto;

use App\Models\Client;

class DtoClient
{
    public function __construct(
        public ?int    $id = null,
        public ?string $domain = null,
        public ?string $licenseHash = null,
        public ?string $tariffCode = null,
    )
    {
    }
    public static function createByModel(Client $model): self
    {
        return new self(
            id: $model->id,
            domain: $model->domain,
            licenseHash: $model->client_license_hash,
            tariffCode: $model->tariff_code,
        );
    }
}
