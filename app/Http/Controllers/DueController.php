<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDueRequest;
use App\Http\Requests\UpdateDueRequest;
use App\Models\Due;
use App\Repositories\DueRepository;
use App\Utils\Util;
use App\Validators\JsonValidator;
use Illuminate\Support\Facades\Storage;

class DueController extends Controller
{
    protected $dueRepository;

    public function __construct(DueRepository $dueRepository)
    {
        $this->dueRepository = $dueRepository;
    }

    public function index()
    {
        $dues = $this->dueRepository->getDues();

        $tableHead = ['Declarante', 'Identificação', 'Número', 'Moeda', 'VMCV Moeda', 'VMLE Moeda', 'Peso Líquido', 'Ações'];

        return view('dues', compact('tableHead', 'dues'));
    }

    public function create()
    {
        return view('save-due');
    }

    public function edit(int $id)
    {
        $due = $this->dueRepository->getDueById($id);

        if ($due) {
            $due->due_itens;
        }

        $tableHead = ['Item', 'Nota/Série/Item', 'Descrição Complementar', 'NCM', 'Enquadramento(s)', 'VMLE Moeda', 'VMCV Moeda', 'Peso Líquido'];

        return view('update-due', compact('tableHead', 'due'));
    }

    public function store(StoreDueRequest $request)
    {
        $filePath = $request->file('json')->storeAs('uploads', 'temp.json');

        $jsonContent = Storage::get($filePath);
        $dueData = json_decode($jsonContent, true);

        if (!JsonValidator::validateDueData($dueData)) {
            return response()->json(['message' => 'JSON inválido'], 400);
        }

        $this->calculateTotals($dueData);

        $this->processDueItems($dueData['due_itens'], $due = $this->dueRepository->createDue($dueData));

        return response()->json(['message' => 'Due processada com sucesso']);
    }

    public function update(UpdateDueRequest $request, int $id)
    {
        $due = $this->dueRepository->getDueById($id);

        if (!$due) {
            return response()->json(['message' => 'Due não encontrado'], 404);
        }

        $due->informacoes_complementares = $request->informacoes_complementares;

        $due->save();

        return response()->json(['message' => 'Due atualizada com sucesso']);
    }

    private function processDueItems(array $dueItems, Due $due)
    {
        foreach ($dueItems as $item) {
            $result = Util::extractDataNfe($item['nfe_chave']);
            $item['nfe_numero'] = $result['nfe_numero'];
            $item['nfe_serie'] = $result['nfe_serie'];

            $item['due_id'] = $due->id;
            $item['vmle_moeda'] = $item['vmle'];
            $item['vmcv_moeda'] = $item['vmcv'];

            $this->dueRepository->createDueItem($item);
        }
    }

    private function calculateTotals(array &$dueData): void
    {
        $totals = [
            'total_vmle_moeda' => null,
            'total_vmcv_moeda' => null,
            'total_peso_liquido' => null,
        ];
    
        foreach ($dueData['due_itens'] as $item) {
            $totals['total_vmle_moeda'] += $item['vmle'];
            $totals['total_vmcv_moeda'] += $item['vmcv'];
            $totals['total_peso_liquido'] += $item['peso_liquido'];
        }

        $dueData = array_merge($dueData, $totals);
    }
}
