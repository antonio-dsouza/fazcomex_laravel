<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="antialiased bg-zinc-900">
    <x-nav-bar />
    <div class="absolute w-full flex justify-end mt-6">
        <div id="toast-success"
            class="hidden items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div id="toasttext" class="ms-3 text-sm font-normal">Sucesso.</div>
            <button onclick="$('#toast-success').addClass('hidden')" type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>
    <div class="bg-zinc-900 flex justify-center items-center w-12/12 h-auto">
        <form class="w-8/12 h-auto flex flex-col justify-center mb-8" id="formEnvio"
            onsubmit="return sendForm(event, {{ $due->id }});">
            <div class="flex flex-col gap-6">
                <div class="relative flex pt-5 items-center">
                    <div class="flex-grow border-t border-gray-400"></div>
                    <span class="flex-shrink mx-4 text-gray-400">Dados Gerais</span>
                    <div class="flex-grow border-t border-gray-400"></div>
                </div>
                <div class="flex gap-2">
                    <div class="w-full">
                        <label htmlFor="declarante"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Declarante</label>
                        <input value="{{ $due->declarante_cpf_cnpj }} - {{ $due->declarante_razao_social }}"
                            type="text" id="declarante"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                    <div class="w-full">
                        <label htmlFor="identificacao"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Identificação</label>
                        <input value="{{ $due->identificacao }}" type="text" id="identificacao"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                    <div class="w-full">
                        <label htmlFor="numero"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Número</label>
                        <input value="{{ $due->numero }}" type="text" id="numero"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                    <div class="w-full">
                        <label htmlFor="moeda"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Moeda</label>
                        <input value="{{ $due->moeda }}" type="text" id="moeda"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="w-full">
                        <label htmlFor="vmle_moeda"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VMLE Moeda</label>
                        <input value="{{ number_format($due->total_vmle_moeda, 2, ',', '.') }}" type="text"
                            id="vmle_moeda"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                    <div class="w-full">
                        <label htmlFor="vmcv_moeda"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VMCV Moeda</label>
                        <input value="{{ number_format($due->total_vmcv_moeda, 2, ',', '.') }}" type="text"
                            id="vmcv_moeda"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                    <div class="w-full">
                        <label htmlFor="peso_liquido"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peso
                            Líquido</label>
                        <input value="{{ number_format($due->total_peso_liquido, 2, ',', '.') }}" type="text"
                            id="peso_liquido"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            disabled />
                    </div>
                </div>
                <div class="relative flex pt-5 items-center">
                    <div class="flex-grow border-t border-gray-400"></div>
                    <span class="flex-shrink mx-4 text-gray-400">Informações Complementares</span>
                    <div class="flex-grow border-t border-gray-400"></div>
                </div>
                <div>
                    <textarea id="informacoes_complementares" name="informacoes_complementares"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Digite...">{{ $due->informacoes_complementares }}</textarea>
                </div>
                <div class="relative flex pt-5 items-center">
                    <div class="flex-grow border-t border-gray-400"></div>
                    <span class="flex-shrink mx-4 text-gray-400">Itens</span>
                    <div class="flex-grow border-t border-gray-400"></div>
                </div>
                <div>
                    <div class="w-full">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    @foreach ($tableHead as $item)
                                        <th key={item} scope="col" class="px-6 py-3">
                                            {{ $item }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($due->due_itens as $item)
                                    <tr key={item.id} class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">
                                            {{ $item->item }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->nfe_numero . '/' . $item->nfe_serie . '/' . $item->nfe_item }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->descricao_complementar }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $item->ncm }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ implode(', ', array_filter([$item->enquadramento1, $item->enquadramento2, $item->enquadramento3, $item->enquadramento4], fn($valor) => $valor !== null)) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($item->vmle_moeda, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($item->vmcv_moeda, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($item->peso_liquido, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="text-white w-full mt-6 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Atualizar</button>
        </form>
    </div>
    <script>
        function sendForm(e, id) {
            e.preventDefault();

            var formData = new FormData(e.currentTarget);

            $.ajax({
                url: `/update-due/${id}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#toasttext').text(response.message);
                    $('#toast-success').addClass('flex');
                    $('#toast-success').removeClass('hidden');
                },
                error: function(error) {
                    $('#error_toasttext').text(error.responseJSON.message);
                    $('#toast-danger').addClass('flex');
                    $('#toast-danger').removeClass('hidden');
                }
            });
            return false;
        }
    </script>
</body>
