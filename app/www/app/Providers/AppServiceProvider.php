<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Service\Gpt\GptClient;
use App\Service\Payment\PaymentProviderYookassa;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();

        $this->app->bind(\App\Service\Api\HttpClientBus::class, function () {
            return new \App\Service\Api\HttpClientBus(
                new Client([
                    'base_uri' => $_ENV['HTTP_URL_SERVICE_API_BUS'],
                    'headers' => [ 'Content-Type' => 'application/json' ]
                ])
            );
        });

        $this->app->bind(GptClient::class, function () {
            return new GptClient(
                new \GuzzleHttp\Client([
                    'base_uri' => 'https://api.openai.com/',
                    'proxy' => env('PROXY_SERVER'),
                ]),
                $_ENV['CHAT_GPT_TOKEN']
            );
        });

        $this->app->bind(PaymentProviderYookassa::class, function () {

            $stack = HandlerStack::create();

            return new PaymentProviderYookassa(
                new Client([
                    'base_uri' => 'https://yoomoney.ru',
                    RequestOptions::ALLOW_REDIRECTS => true,
                    'handler' => $stack,
                ]),
                $stack,
                new \App\Service\Payment\MiddlewarePaymentProviderUrl()
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::environment('production')) {
            URL::forceScheme('https');
        }
    }
}
