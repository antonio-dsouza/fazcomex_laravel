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

        return view('dues')->with(compact('tableHead', 'dues'));
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

        return view('update-due')->with(compact('tableHead', 'due'));
    }

    public function store(StoreDueRequest $request)
    {
        $filePath = $request->file('json')->storeAs('uploads', 'temp.json');

        if (!$filePath) {
            return Util::createMessage('file_upload_error', 500);
        }

        $jsonContent = Storage::get($filePath);
        $dueData = json_decode($jsonContent, true);

        if (!JsonValidator::validateDueData($dueData)) {
            return Util::createMessage('invalid_json', 400);
        }

        $this->calculateTotals($dueData);

        $due = $this->dueRepository->createDue($dueData);
        $this->processDueItems($dueData['due_itens'], $due);    

        return Util::createMessage('processed_successfully');
    }

    public function update(UpdateDueRequest $request, int $id)
    {
        $due = $this->dueRepository->getDueById($id);

        if (!$due) {
            return Util::createMessage('not_found_message', 404);
        }

        $due->update($request->validated());

        return Util::createMessage('updated_successfully');
    }

    private function processDueItems(array $dueItems, Due $due)
    {
        foreach ($dueItems as $dueItem) {
            $result = Util::extractDataNfe($dueItem['nfe_chave']);
            $dueItem['nfe_numero'] = $result['nfe_numero'];
            $dueItem['nfe_serie'] = $result['nfe_serie'];

            $dueItem['due_id'] = $due->id;
            $dueItem['vmle_moeda'] = $dueItem['vmle'];
            $dueItem['vmcv_moeda'] = $dueItem['vmcv'];

            $this->dueRepository->createDueItem($dueItem);
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
