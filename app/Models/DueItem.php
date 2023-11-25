<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DueItem extends Model
{
    use HasFactory;

    protected $table = 'due_itens';

    protected $fillable = [
        'due_id',
        'item',
        'nfe_chave',
        'nfe_numero',
        'nfe_serie',
        'nfe_item',
        'descricao_complementar',
        'ncm',
        'vmle_moeda',
        'vmcv_moeda',
        'peso_liquido',
        'enquadramento1',
        'enquadramento2',
        'enquadramento3',
        'enquadramento4',
    ];
}
