<?php

namespace App\Service;

use App\Service\Gpt\ContextMessage;
use App\Service\Gpt\ContextMessageCollection;
use App\Service\Gpt\DtoGptAnswer;
use App\Service\Gpt\EnumRole;
use App\Service\Gpt\GptClient;
use Gioni06\Gpt3Tokenizer\Gpt3Tokenizer;

class ServiceGptPrompt
{
    public function __construct(
        protected GptClient $client,
        protected Gpt3Tokenizer $gpt3Tokenizer,
    ) {
    }

    /**
     * @throws \App\Exceptions\ExceptionBase
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function prompt(string $text, string $gptModel): DtoGptAnswer
    {
        $message = new ContextMessage(
            $text,
            EnumRole::ROLE_USER,
            $this->gpt3Tokenizer->count($text),
        );

        $collection = new ContextMessageCollection();
        $collection->push($message);

        return $this->client->prompt($collection, $gptModel);
    }
}
