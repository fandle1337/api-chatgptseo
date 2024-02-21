<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionBase;
use App\Helper\HelperBitrixKey;
use App\Http\Requests\RequestGptPrompt;
use App\Http\Response\Response;
use App\Repository\RepositoryClient;
use App\Repository\RepositoryGptModel;
use App\Service\ServiceClientLimit;
use App\Service\ServiceGptPrompt;
use App\Service\ServiceTokenUsage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ControllerGptPrompt extends ControllerBase
{
    public function __construct(
        protected ServiceGptPrompt   $serviceGptPrompt,
        protected ServiceTokenUsage  $serviceTokenUsage,
        protected ServiceClientLimit $serviceCheckClientLimit,
        protected RepositoryGptModel $repositoryGptModel,
        protected RepositoryClient   $repositoryClient,
    )
    {
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \App\Exceptions\ExceptionBase
     */
    public function __invoke(RequestGptPrompt $request): JsonResponse
    {
        $clientLicenseHash = HelperBitrixKey::toHash($request->validated("license_key"));

        $client = $this->repositoryClient->getByHash($clientLicenseHash);

        if (!$client) {
            throw new ExceptionBase("Client not found", 404);
        }

        if (!$this->serviceCheckClientLimit->isAllowUsage($clientLicenseHash)) {
            throw new ExceptionBase("The limit of tokens used for the client has been exceeded", 402);
        }

        $gptModel = $this->repositoryGptModel->getByCode($request->validated('gpt_code'));

        $dtoGptAnswer = $this->serviceGptPrompt->prompt(
            $request->validated("prompt"),
            $gptModel->gptModelCode,
        );

        $usageId = $this->serviceTokenUsage->create(
            $client->id,
            $gptModel->code,
            $dtoGptAnswer,
            $request->validated("task_id"),
            $request->validated("element_id"),
        );

        if (!$usageId) {
            return Response::json('Creating usage error');
        }

        Log::info("request client", [
            "hash"       => $clientLicenseHash,
            "client_id"  => $client->id,
            "task_id"    => $request->validated("task_id"),
            "element_id" => $request->validated("element_id"),
            "headers"    => $dtoGptAnswer->headers,
            "timeout"    => $dtoGptAnswer->timeout,
            'usage'      => $usageId,
        ]);

        return Response::json([
            "content" => $dtoGptAnswer->content,
            "timeout" => $dtoGptAnswer->timeout
        ]);
    }
}
