<?php

namespace app\Dto;

class DtoOrder
{
    public function __construct(
        public ?string $hash = null,
        public ?int    $clientId = null,
        public ?int    $price = null,
        public ?string $datePayed = null,
        public ?string $type = null,
    )
    {
    }
}
