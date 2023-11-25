<?php

namespace App\Validators;

class JsonValidator
{
    public static function validateDueData($data)
    {
        return isset($data['declarante_cpf_cnpj']) &&
            isset($data['declarante_razao_social']) &&
            isset($data['identificacao'])  &&
            isset($data['numero'])  &&
            isset($data['moeda'])  &&
            isset($data['incoterm']);
    }
}
