<?php

namespace App\Service;


use App\Models\ClientTokenUsage;
use App\Repository\RepositoryGptModel;
use App\Service\Gpt\DtoGptAnswer;

class ServiceTokenUsage
{
    public function __construct(
        protected RepositoryGptModel $repositoryGptModel,
    )
    {
    }

    public function create(
        int          $clientId,
        string       $gptModelCode,
        DtoGptAnswer $dtoGptAnswer,
        ?int         $taskId,
        ?int         $elementId
    ): bool|int
    {
        $gptModel = $this->repositoryGptModel->getByCode($gptModelCode);

        $model = ClientTokenUsage::create([
            'client_id'              => $clientId,
            'gpt_model_code'         => $gptModelCode,
            'prompt_count_token_in'  => $in = $dtoGptAnswer->prompt_tokens,
            'prompt_count_token_out' => $out = $dtoGptAnswer->completion_tokens,
            'price_token_in'         => $gptModel->priceIn * $in,
            'price_token_out'        => $gptModel->priceOut * $out,
            'element_id'             => $elementId,
            'task_id'                => $taskId,
        ]);

        return $model?->id ?? false;

    }
}
