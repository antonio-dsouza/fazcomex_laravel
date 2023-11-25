<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="antialiased bg-zinc-900">
	<x-nav-bar />
    <div class="bg-zinc-900 flex justify-center items-center w-12/12 h-screen">
        <table class="w-10/12 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @foreach ($tableHead as $item)
                        <th key={item} scope="col" class="px-6 py-3">
                            {{ $item }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dues as $due)
                    <tr class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{$due->declarante_cpf_cnpj . ' - ' . $due->declarante_razao_social}}
                        </td>
                        <td class="px-6 py-4">
                            {{$due->identificacao}}
                        </td>
                        <td class="px-6 py-4">
                            {{$due->numero}}
                        </td>
                        <td class="px-6 py-4">
                            {{$due->moeda}}
                        </td>
                        <td class="px-6 py-4">
                            {{number_format($due->total_vmle_moeda, 2, ',', '.')}}
                        </td>
                        <td class="px-6 py-4">
                            {{number_format($due->total_vmcv_moeda, 2, ',', '.')}}
                        </td>
                        <td class="px-6 py-4">
                            {{number_format($due->total_peso_liquido, 2, ',', '.')}}
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="window.location.href='edit-due/{{$due->id}}'" class="flex p-1 bg-gray-500 rounded-xl hover:rounded-3xl hover:bg-gray-600 transition-all duration-300 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
