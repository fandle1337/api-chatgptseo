<?php

namespace app\Repository;

use App\Models\ClientTokenUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RepositoryClientTokenUsage
{
    public function getTotalByClientId(int $clientId): float
    {
        $response = ClientTokenUsage::where('client_id', $clientId)->get();

        $priceIn = $response->sum('price_token_in');
        $priceOut = $response->sum('price_token_out');

        return round($priceIn + $priceOut, 3);
    }

    public function getTaskStatsByClientId(int $clientId): array
    {
        $response = ClientTokenUsage::where('client_id', $clientId)
            ->get()
            ->groupBy('task_id');

        foreach ($response as $taskId => $stats) {
            $result[] = [
                'task_id' => $taskId,
                'value' => round($stats->sum('price_token_in') + $stats->sum('price_token_out'), 2),
                'count' => $stats->count(),
                'date' => Carbon::parse($stats->sortByDesc('created_at')->first()->created_at)
                    ->format('Y-m-d')
            ];
        }

        return $result ?? [];
    }

    public function getModelStatsByClientId(?int $clientId): array
    {
        $response = ClientTokenUsage::where('client_id', $clientId)
            ->get()
            ->groupBy('gpt_model_code');

        foreach ($response as $gptModelCode => $stats) {
            $result[] = [
                'name' => $gptModelCode,
                'value' => round($stats->sum('price_token_in') + $stats->sum('price_token_out'), 2),
                'count' => $stats->groupBy('task_id')->count(),
            ];
        }

        return $result ?? [];
    }

    public function getMouthStatsByClientId(?int $clientId): array
    {
        $response = ClientTokenUsage::where('client_id', $clientId)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(price_token_in + price_token_out) as total_price'),
                DB::raw('COUNT(*) as usage_count')
            )
            ->groupBy('year', 'month')
            ->get();

        foreach ($response as $stats) {
            $result[] = [
                'date' => $stats->year . '-' . $stats->month,
                'value' => round($stats->total_price, 2),
                'count' => $stats->usage_count,
            ];
        }

        return $result ?? [];
    }
}
