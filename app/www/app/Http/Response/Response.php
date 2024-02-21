<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class Response
{
    public static function json(mixed $data, int $code = 200): JsonResponse
    {
        $data = [
            "status" => $code !== 200 ? "error" : "success",
            "data" => $data
        ];

        return response()->json($data, $code === 0 ? 400 : $code);
    }
}
