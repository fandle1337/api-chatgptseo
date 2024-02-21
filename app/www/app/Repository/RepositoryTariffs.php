<?php

namespace App\Repository;

use App\Models\ClientTariff;

class RepositoryTariffs
{
    public function getPriceByTariffCode(string $tariffCode): int
    {
        $tariff = ClientTariff::where("code", $tariffCode)->first();

        return $tariff->price;
    }

}
