<?php

namespace App\Service\Gpt;


use App\Exceptions\ExceptionBase;
use GuzzleHttp\Client;

class DtoGptAnswer
{
    public function __construct(
        public ?string $content = null,
        public ?int $prompt_tokens = null,
        public ?int $completion_tokens = null,
        public ?int $timeout = 0,
        public ?array $headers = []
    ) {
    }
}
