<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDueRequest;
use Illuminate\Http\Request;
use App\Models\Due;
use App\Repositories\DueRepository;
use App\Utils\Util;
use App\Validators\JsonValidator;

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

        $tableHead = ['Item', 'Nota/Série/Item', 'Descrição Complementar', 'NCM', 'Enquadramento(s)', 'VMLE Moeda', 'VMCV Moeda', 'Peso Líquido'];

        return view('update-due', compact('tableHead', 'due'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'json' => 'required|mimes:json|max:2048',
        ]);

        $filePath = $request->file('json')->storeAs('uploads', 'temp.json');

        $jsonContent = file_get_contents(storage_path("app/$filePath"));
        $dueData = json_decode($jsonContent, true);

        if (!JsonValidator::validateDueData($dueData)) {
            return response()->json(['message' => 'JSON inválido'], 400);
        }

        $due = $this->dueRepository->createDue($dueData);

        foreach ($dueData['due_itens'] as $item) {
            $result = Util::extractDataNfe($item['nfe_chave']);
            $item['nfe_numero'] = $result['nfe_numero'];
            $item['nfe_serie'] = $result['nfe_serie'];

            $this->dueRepository->createDueItem($due, $item);
        }

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
}
