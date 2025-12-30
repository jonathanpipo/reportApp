<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;
use App\Models\Categoria;

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

    /**
     * Carrega dados das avaliações (Muito bom, Bom, etc.)
     */
    public function carregarDados()
    {
        $avaliacoes = Reporte::select('avaliacao')
            ->where('ativo', true)
            ->get()
            ->groupBy('avaliacao')
            ->map(fn($item) => $item->count());

        $this->labels = $avaliacoes->keys()->toArray();
        $this->data = $avaliacoes->values()->toArray();
    }

    /**
     * Carrega dados das categorias (agora usando relacionamento)
     */
    public function carregarDadosCategoria()
    {
        $categorias = Reporte::with('categoria')
            ->where('ativo', true)
            ->get()
            ->groupBy(fn($item) => $item->categoria->descricao ?? 'Sem categoria')
            ->map(fn($item) => $item->count());

        $this->labelsCategoria = $categorias->keys()->toArray();
        $this->dataCategoria = $categorias->values()->toArray();
    }

    /**
     * Carrega totais da escala Likert
     */
    public function carregarTodasCategoriasAvaliacaoInfraestrutura()
    {
        $this->totaisAvaliacaoInfraestrutura = [
            'Muito bom' => Reporte::where('avaliacao', 'Muito bom')->count(),
            'Bom' => Reporte::where('avaliacao', 'Bom')->count(),
            'Regular' => Reporte::where('avaliacao', 'Regular')->count(),
            'Ruim' => Reporte::where('avaliacao', 'Ruim')->count(),
            'Muito ruim' => Reporte::where('avaliacao', 'Muito ruim')->count(),
        ];
    }

    /**
     * Contagens por categoria
     */
    public function carregarTodasCategoriasDenuncias()
    {
        $lista = [
            'Asfalto danificado',
            'Sinalização deficiente',
            'Direção perigosa',
            'Congestionamento recorrente',
            'Drenagem de água',
        ];

        foreach ($lista as $categoria) {
            $this->totaisCategoriasDenuncias[$categoria] =
                Reporte::whereHas('categoria', fn($q) => $q->where('descricao', $categoria))
                    ->count();
        }
    }

    /**
     * Cálculo da opinião geral
     */
    public function calcularOpiniaoGeral()
    {
        $valoresLikert = [
            'Muito ruim' => 1,
            'Ruim' => 2,
            'Regular' => 3,
            'Bom' => 4,
            'Muito bom' => 5,
        ];

        $avaliacoes = Reporte::where('ativo', true)
            ->pluck('avaliacao');

        if ($avaliacoes->isEmpty()) {
            return null;
        }

        $notas = $avaliacoes->map(fn($avaliacao) => $valoresLikert[$avaliacao] ?? 0);

        $media = $notas->avg();
        $mediaArredondada = round($media);

        return array_search($mediaArredondada, $valoresLikert) ?: 'Sem dados';
    }

    /**
     * Renderização da página
     */
    public function render()
    {
        $reportes = Reporte::with('categoria')
            ->where('ativo', true)
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
