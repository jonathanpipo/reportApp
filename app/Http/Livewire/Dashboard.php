<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \App\Models\Reporte;

class Dashboard extends Component
{
    public $opiniaoGeral;

    public $labels = [];
    public $data = [];

    public $labelsCategoria = [];
    public $dataCategoria = [];
    public $totaisAvaliacaoInfraestrutura = [];
    public $totaisCategoriasDenuncias = [];

    public function mount()
    {
        $this->carregarDados();
        $this->carregarDadosCategoria();
        $this->carregarTodasCategoriasAvaliacaoInfraestrutura();
        $this->opiniaoGeral = $this->calcularOpiniaoGeral();
        $this->carregarTodasCategoriasDenuncias();
    }

    public function carregarDados()
    {
        $avaliacoes = Reporte::select('avaliacaoInfraestrutura')
            ->where('ativo', true)
            ->get()
            ->groupBy('avaliacaoInfraestrutura')
            ->map(fn($item) => $item->count());

        $this->labels = $avaliacoes->keys()->toArray();
        $this->data = $avaliacoes->values()->toArray();
    }

    public function carregarDadosCategoria()
    {
        $categorias = Reporte::select('categoria')
            ->where('ativo', true)
            ->get()
            ->groupBy('categoria')
            ->map(fn($item) => $item->count());

        $this->labelsCategoria = $categorias->keys()->toArray();
        $this->dataCategoria = $categorias->values()->toArray();
    }

    public function carregarTodasCategoriasAvaliacaoInfraestrutura()
    {
        $this->totaisAvaliacaoInfraestrutura = [
            'Muito bom' => Reporte::where('avaliacaoInfraestrutura', 'Muito bom')->count(),
            'Bom' => Reporte::where('avaliacaoInfraestrutura', 'Bom')->count(),
            'Regular' => Reporte::where('avaliacaoInfraestrutura', 'Regular')->count(),
            'Ruim' => Reporte::where('avaliacaoInfraestrutura', 'Ruim')->count(),
            'Muito ruim' => Reporte::where('avaliacaoInfraestrutura', 'Muito ruim')->count(),
        ];
    }

    public function carregarTodasCategoriasDenuncias()
    {
        $this->totaisCategoriasDenuncias = [
            'Asfalto danificado' => Reporte::where('categoria', 'Asfalto danificado')->count(),
            'Sinalização deficiente' => Reporte::where('categoria', 'Sinalização deficiente')->count(),
            'Direção perigosa' => Reporte::where('categoria', 'Direção perigosa')->count(),
            'Congestionamento recorrente' => Reporte::where('categoria', 'Congestionamento recorrente')->count(),
            'Drenagem de água' => Reporte::where('categoria', 'Drenagem de água')->count(),
        ];
    }

    //Cálculo da opinião geral sobre a infraestrutura das vias da cidade
    public function calcularOpiniaoGeral()
    {
        // Array com a atribuição de valores
        $valoresLikert = [
            'Muito ruim' => 1,
            'Ruim' => 2,
            'Regular' => 3,
            'Bom' => 4,
            'Muito bom' => 5,
        ];

        // Puxando todos os votos ativos
        $avaliacoes = Reporte::where('ativo', true)
            ->pluck('avaliacaoInfraestrutura');

        // Se não houver avaliações, retorna null
        if ($avaliacoes->isEmpty()) {
            return null;
        }

        // Transformando cada avaliação em valor numérico
        $notas = $avaliacoes->map(fn($avaliacao) => $valoresLikert[$avaliacao] ?? 0);

        // Calculando a média
        $media = $notas->avg();

        // Retornando a avaliação correspondente à média arredondada
        $mediaArredondada = round($media);

        // Buscar a chave correspondente ao valor arredondado
        $opiniaoGeral = array_search($mediaArredondada, $valoresLikert);

        return $opiniaoGeral ?? 'Sem dados';
    }

    //Paginação da tabela
    public function render()
    {
        $reportes = Reporte::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dashboard', [
            'reportes' => $reportes,
            'totalMuitoBom' => $this->totaisAvaliacaoInfraestrutura['Muito bom'] ?? 0,
            'totalBom' => $this->totaisAvaliacaoInfraestrutura['Bom'] ?? 0,
            'totalRegular' => $this->totaisAvaliacaoInfraestrutura['Regular'] ?? 0,
            'totalRuim' => $this->totaisAvaliacaoInfraestrutura['Ruim'] ?? 0,
            'totalMuitoRuim' => $this->totaisAvaliacaoInfraestrutura['Muito ruim'] ?? 0,
            'totalAsfaltoDanificado' => $this->totaisCategoriasDenuncias['Asfalto danificado'] ?? 0,
            'totalSinalizaçãoDeficiente' => $this->totaisCategoriasDenuncias['Sinalização deficiente'] ?? 0,
            'totalDireçãoPerigosa' => $this->totaisCategoriasDenuncias['Direção perigosa'] ?? 0,
            'totalCongestionamentoRecorrente' => $this->totaisCategoriasDenuncias['Congestionamento recorrente'] ?? 0,
            'totalDrenagemAgua' => $this->totaisCategoriasDenuncias['Drenagem de água'] ?? 0,
        ]);
    }
}

