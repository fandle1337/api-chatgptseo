<?php

namespace app\Repository;

use app\Dto\DtoOrder;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class RepositoryOrder
{
    public function getTotalByClientId(int $clientId): int
    {
        return Order::where('client_id', $clientId)
            ->whereNotNull('date_payed')
            ->get()
            ->sum('price');
    }

    public function getStatsByClientId(int $clientId): Collection
    {
        return Order::where('client_id', $clientId)
            ->whereNotNull('date_payed')
            ->orderBy('date_payed', 'desc')
            ->get();
    }

    public function create(DtoOrder $dtoOrder): bool|int
    {
        $model = Order::Create([
            'hash'       => $dtoOrder->hash,
            'client_id'  => $dtoOrder->clientId,
            'price'      => $dtoOrder->price,
            'date_payed' => $dtoOrder->datePayed,
            'type'       => $dtoOrder->type,
        ]);

        return $model?->id ?? false;
    }
}
