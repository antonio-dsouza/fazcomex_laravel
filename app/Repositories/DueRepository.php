<?php

namespace App\Repositories;

use App\Models\Due;
use App\Models\DueItem;
use Illuminate\Database\Eloquent\Collection;

class DueRepository
{
    public function createDue(array $dadosDue): Due
    {
        return Due::create($dadosDue);
    }

    public function createDueItem(array $dadosItem): DueItem
    {
        return DueItem::create($dadosItem);
    }

    public function getDues(): Collection
    {
        return Due::all();
    }

    public function getDueById(int $id): Due
    {
        return Due::find($id);
    }
}
