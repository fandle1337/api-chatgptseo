<?php

namespace App\Http\Controllers;

use App\Enum\EnumErrorResponse;
use Illuminate\Http\JsonResponse;


class ControllerBase extends Controller
{
    /**
     * success response method.
     *
     * @param mixed $result
     * @return JsonResponse
     */
    public static function sendResponse(mixed $result): JsonResponse
    {
        $response = [
            'success' => true,
            'result'    => $result,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public static function sendError($error, int $code = 500): JsonResponse
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
