<?php

namespace App\Utils;

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
}
