<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    use HasFactory;

    protected $fillable = [
        'declarante_cpf_cnpj',
        'declarante_razao_social',
        'identificacao',
        'numero',
        'moeda',
        'incoterm',
        'informacoes_complementares',
        'total_vmle_moeda',
        'total_vmcv_moeda',
        'total_peso_liquido'
    ];

    public function due_itens()
    {
        return $this->hasMany(DueItem::class, 'due_id');
    }
}
