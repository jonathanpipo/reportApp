<div class="bg-gradient-to-b from-gray-100 to-gray-200 flex flex-col gap-6">
    <div class="text-white shadow-inner">
        <div class="container mx-auto flex-col items-center justify-between py-4 px-4">
            <h1 class="text-2xl font-semibold text-gray-700">Indicadores</h1>
            <p class="text-sm text-gray-600 mt-1">
            Os indicadores desta tela apresentam de forma visual, simplificada e resumida os principais dados coletados, permitindo acompanhar métricas, 
            valores totais e o histórico tabelado de ocorrências registradas.
            </p>
        </div>
    </div>
    <div class="container mx-auto flex flex-col gap-6 p-4">

        <!-- Gráficos lado a lado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Gráfico 1: Sentimento Geral -->
            <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center gap-4">
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Sentimento Geral: {{ $opiniaoGeral }}</h2>
                </div>
                <div class="grid grid-cols-1 gap-3 w-full max-w-md">
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Muito bom: {{ $totalMuitoBom }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Bom: {{ $totalBom }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Regular: {{ $totalRegular }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Ruim: {{ $totalRuim }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Muito ruim: {{ $totalMuitoRuim }}</span>
                    </div>
                </div>
                <canvas id="pieChartInfraestrutura" class="w-full h-64 max-w-sm"></canvas>
            </div>

            <!-- Gráfico 2: Total de Denúncias e Categorias -->
            <div class="bg-white p-6 rounded-2xl shadow-lg flex flex-col items-center gap-4">
                <div class="flex flex-col items-center">
                    <h2 class="text-xl font-semibold text-gray-700 mb-1">Total de Denúncias:
                        {{ collect($dataCategoria)->sum() }}</h2>
                </div>
                <div class="grid grid-cols-1 gap-3 w-full max-w-md">
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Asfalto danificado: {{ $totalAsfaltoDanificado }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Sinalização deficiente:
                            {{ $totalSinalizaçãoDeficiente }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Direção perigosa: {{ $totalDireçãoPerigosa }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Congestionamento recorrente:
                            {{ $totalCongestionamentoRecorrente }}</span>
                    </div>
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center justify-between">
                        <span class="font-medium text-gray-700">Drenagem de água: {{ $totalDrenagemAgua }}</span>
                    </div>
                </div>
                <canvas id="pieChartCategoria" class="w-full h-64 max-w-sm mt-6"></canvas>
            </div>
        </div>

        <!-- Tabela de últimos reportes -->
        <h1 class="text-2xl font-semibold text-gray-700">Listagem das denúncias enviadas</h1>
        <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Data</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Categoria</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Comentário</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Avaliação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($reportes as $reporte)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $reporte->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ ucfirst($reporte->categoria) }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                {{ $reporte->descricao ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-sm font-semibold text-gray-800">
                                {{ $reporte->avaliacaoInfraestrutura ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                Nenhum reporte encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $reportes->links() }}
            </div>
        </div>
    </div>
</div>



<script>
    // ===== PIE CHART INFRAESTRUTURA =====
    const labelsInfraestrutura = @json($labels);
    const dataInfraestrutura = @json($data);

    const ctxInfra = document.getElementById('pieChartInfraestrutura').getContext('2d');

    const pieChartInfraestrutura = new Chart(ctxInfra, {
        type: 'pie',
        data: {
            labels: labelsInfraestrutura,
            datasets: [{
                label: 'Avaliações',
                data: dataInfraestrutura,
                backgroundColor: [
                    '#ef4444', '#f97316', '#facc15', '#22c55e', '#3b82f6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 20
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.parsed}`;
                        }
                    }
                }
            }
        }
    });
    // ===== PIE CHART CATEGORIA =====
    const labelsCategoria = @json($labelsCategoria);
    const dataCategoria = @json($dataCategoria);

    const ctxCategoria = document.getElementById('pieChartCategoria').getContext('2d');

    const pieChartCategoria = new Chart(ctxCategoria, {
        type: 'pie',
        data: {
            labels: labelsCategoria,
            datasets: [{
                label: 'Quantidade',
                data: dataCategoria,
                backgroundColor: [
                    '#ef4444', '#f97316', '#facc15', '#22c55e', '#3b82f6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 20
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.parsed}`;
                        }
                    }
                }
            }
        }
    });
    // ===== DADOS TOTAIS AVALIAÇÃO INFRAESTRUTURA =====
    const totaisAvaliacaoInfraestrutura = @json($totaisAvaliacaoInfraestrutura);

    // ===== DADOS TOTAIS CATEGORIAS DENUNCIAS =====
    const totaisCategoriasDenuncias = @json($totaisAvaliacaoInfraestrutura);
</script>
