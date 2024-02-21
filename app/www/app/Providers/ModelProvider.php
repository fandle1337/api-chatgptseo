<?php

namespace App\Providers;

use App\Dto\DtoModelText;
use App\Enum\EnumGptModel;
use Illuminate\Support\ServiceProvider;

class ModelProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind("ai.models", function ($app) {
            return [
                new DtoModelText(
                    EnumGptModel::GPT_3_5_TURBO->value,
                    'gpt-3.5-turbo-16k',
                    'GPT-3.5 Turbo',
                    0.90 / 1000,
                    1.90 / 1000,
                    16 * 1024,
                    true,
                    'text of description'
                ),

                new DtoModelText(
                    EnumGptModel::GPT_4_5_TURBO->value,
                    "gpt-4-1106-preview",
                    "GPT-4.5 Turbo",
                    4.90 / 1000,
                    9.90 / 1000,
                    128 * 1024,
                    true,
                    'text of description',
                )
            ];
        });
    }
}
