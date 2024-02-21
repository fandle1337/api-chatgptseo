<?php

namespace App\Service\Gpt;


use App\Exceptions\ExceptionBase;
use GuzzleHttp\Client;

class GptClient
{

    public function __construct(
        protected Client $httpClient,
        protected string $token
    )
    {
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ExceptionBase
     */
    public function prompt(ContextMessageCollection $contextMessageCollection, string $gptModel): DtoGptAnswer
    {
        $result = $this->httpClient->post('/v1/chat/completions', [
            "headers" => [
                'Authorization' => 'Bearer ' . $this->token,
                "Content-Type"  => "application/json"
            ],
            'timeout' => 120,
            "body"    => json_encode([
                "model"    => $gptModel,
                "messages" => array_reverse($contextMessageCollection->toArray())
            ], JSON_UNESCAPED_UNICODE)
        ]);

        $headers = $result->getHeaders();
        $json = $result->getBody()->getContents();

        if (!$result = json_decode($json, true)) {
            throw new ExceptionBase("Не корректный json");
        }


        if (empty($result['choices'][0]['message']['content'])) {
            throw new ExceptionBase("Не корректные ключи");
        }

        return new DtoGptAnswer(
            $result['choices'][0]['message']['content'],
            $result['usage']['prompt_tokens'],
            $result['usage']['completion_tokens'],
            $this->getTimeoutRequest($headers),
            $headers
        );
    }

    protected function getTimestampToken(int $remains, int $total, string $timeout): int
    {
        if (($remains / $total * 100) <= 30) {
            return $this->timeToTimestamp($timeout);
        }

        return 0;
    }

    protected function getTimestampRequest(int $remains, int $total, string $timeout): int
    {
        if (($remains / $total * 100) <= 30) {
            return $this->timeToTimestamp($timeout);
        }

        return 0;
    }

    protected function timeToTimestamp($timeString): int
    {
        return strtotime("+10minute") - time();
    }


    // Если токенов меньше чем 30% от общей суммы, то мы отдаем таймаут
    // Если запросов меньше чем 30% от общей суммы, то мы отдаем таймаут
    // Если есть таймаут токенов и таймаут запросов, то выбираем самый длинный и его отправляем
    protected function getTimeoutRequest($headers)
    {
        $timeoutToken = $this->getTimestampToken(
            $headers['x-ratelimit-remaining-tokens'][0],
            $headers['x-ratelimit-limit-tokens'][0],
            $headers['x-ratelimit-reset-tokens'][0],
        );

        $timeoutRequest = $this->getTimestampRequest(
            $headers['x-ratelimit-remaining-requests'][0],
            $headers['x-ratelimit-limit-requests'][0],
            $headers['x-ratelimit-reset-requests'][0],
        );

        return max($timeoutRequest, $timeoutToken);
    }
}
