<?php

namespace App\Dto;

class DtoModelText
{
    public function __construct(
        public ?string $code = null,
        public ?string $gptModelCode = null,
        public ?string $name = null,
        public ?float  $priceIn = null,
        public ?float  $priceOut = null,
        public ?int    $tokenLimit = null,
        public bool    $active = true,
        public ?string $description = null,

    )
    {
    }
}
