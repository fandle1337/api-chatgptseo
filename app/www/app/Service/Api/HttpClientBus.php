<?php

namespace App\Service\Api;

use App\Exceptions\ExceptionBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;

class HttpClientBus
{
    const CACHE_TIME = 0;

    public function __construct(protected Client $client)
    {
    }

    /**
     * @throws ExceptionBase
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isAuth(string $moduleCode, string $licenseKey)
    {
        try {
            $jsonResponse = $this->client->post('/api/client/auth/',[
                \GuzzleHttp\RequestOptions::JSON => [
                    'module_code' => $moduleCode,
                    'key' => $licenseKey
                ]
            ]);
        } catch (ServerException|ClientException $e) {
            $jsonResponse = $e->getResponse();
        } catch (ConnectException $e ) {
            throw new ExceptionBase($e->getMessage(), 500);
        }

        $response = json_decode($jsonResponse->getBody()->getContents());

        return $response->success;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ExceptionBase
     */
    public function isAuthWithCache(string $moduleCode, string $licenseKey)
    {
        $key = md5($moduleCode . $licenseKey);

        if($result = Cache::get($key)) {
            return $result['c'];
        }

        $response = $this->isAuth($moduleCode, $licenseKey);
        Cache::set($key, ['c' => $response], self::CACHE_TIME);

        return $response;
    }

    /**
     * @throws ExceptionBase
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function clientIsDemo(string $moduleCode, string $clientLicenseHash)
    {
        try {
            $jsonResponse = $this->client->post('/api/client/isDemo/',[
                \GuzzleHttp\RequestOptions::JSON => [
                    'module_code' => $moduleCode,
                    'client_license_hash' => $clientLicenseHash
                ]
            ]);
        } catch (ServerException|ClientException $e) {
            $jsonResponse = $e->getResponse();
        } catch (ConnectException $e ) {
            throw new ExceptionBase($e->getMessage(), 500);
        }

        $response = json_decode($jsonResponse->getBody()->getContents());

        if(!$response->success) {
            throw new ExceptionBase($response->message, 500);
        }

        return $response->result;
    }
}
