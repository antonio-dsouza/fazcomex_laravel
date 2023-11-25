<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

class Util
{
    public static function extractDataNfe(string $nfeChave)
    {
        $serie = substr($nfeChave, 22, 3);
        $number = substr($nfeChave, 25, 9);

        return [
            'nfe_serie' => $serie,
            'nfe_numero' => $number,
        ];
    }

    public static function createMessage(string $key, int $statusCode = 200): JsonResponse
    {
        return response()->json(['message' => __('due.' . $key)], $statusCode);
    }
}
