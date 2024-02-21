<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Dto\DtoModelText;
use App\Helper\HelperBitrixKey;
use App\Models\ClientTokenUsage;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('client_tariffs')->insert([
            [
                'code'  => \App\Enum\EnumClientTariff::DEMO->name,
                'name'  => "Демо версия",
                'price' => 49
            ],
            [
                'code'  => \App\Enum\EnumClientTariff::REAL->name,
                'name'  => "Реальный клиент",
                'price' => 490
            ]
        ]);

//        DB::table('clients')->insert([
//            'domain'              => 'dev.skyweb24.ru',
//            'client_license_hash' => HelperBitrixKey::toHash('NFR-ML-O4YP17UOZ8NNK0WV'),
//            'tariff_code'         => 'real',
//        ]);

//        Order::factory(1)->create();
//        ClientTokenUsage::factory(100)->create();
    }
}
