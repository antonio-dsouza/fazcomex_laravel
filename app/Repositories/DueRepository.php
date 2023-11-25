<?php

namespace App\Repositories;

use App\Models\Due;
use App\Models\DueItem;
use Illuminate\Database\Eloquent\Collection;

class DueRepository
{
    public function createDue(array $dadosDue): Due
    {
        return Due::create([
            'declarante_cpf_cnpj' => $dadosDue['declarante_cpf_cnpj'],
            'declarante_razao_social' => $dadosDue['declarante_razao_social'],
            'identificacao' => $dadosDue['identificacao'],
            'numero' => $dadosDue['numero'],
            'moeda' => $dadosDue['moeda'],
            'incoterm' => $dadosDue['incoterm'],
            'informacoes_complementares' => $dadosDue['informacoes_complementares'],
            'total_vmle_moeda' => array_reduce($dadosDue['due_itens'], function ($carry, $item) {return $carry + $item['vmle'];}, 0),
            'total_vmcv_moeda' => array_reduce($dadosDue['due_itens'], function ($carry, $item) {return $carry + $item['vmcv'];}, 0),
            'total_peso_liquido' => array_reduce($dadosDue['due_itens'], function ($carry, $item) {return $carry + $item['peso_liquido'];}, 0)
        ]);
    }

    public function createDueItem(Due $due, array $dadosItem): DueItem
    {
        return DueItem::create([
            'due_id' => $due->id,
            'item' => $dadosItem['item'],
            'nfe_chave' => $dadosItem['nfe_chave'],
            'nfe_numero' => $dadosItem['nfe_numero'],
            'nfe_serie' => $dadosItem ['nfe_serie'],
            'nfe_item' => $dadosItem['nfe_item'],
            'descricao_complementar' => $dadosItem['descricao_complementar'],
            'ncm' => $dadosItem['ncm'],
            'vmle_moeda' => $dadosItem['vmle'] ?? null,
            'vmcv_moeda' => $dadosItem['vmcv'] ?? null,
            'peso_liquido' => $dadosItem['peso_liquido'] ?? null,
            'enquadramento1' => $dadosItem['enquadramento1'] ?? null,
            'enquadramento2' => $dadosItem['enquadramento2'] ?? null,
            'enquadramento3' => $dadosItem['enquadramento3'] ?? null,
            'enquadramento4' => $dadosItem['enquadramento4'] ?? null,
        ]);
    }

    public function getDues(): Collection  {
        return Due::all();
    }

    public function getDueById(int $id): Due  {
        $due = Due::find($id);

        if ($due) {
            $due->due_itens;
        }

        return $due;
    }
}
