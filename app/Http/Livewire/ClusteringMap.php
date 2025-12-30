<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class ClusteringMap extends Component
{
    public $clusterReportesAsfaltoDanificado = [];
    public $clusterReportesSinalizacaoDeficiente = [];
    public $clusterReportesDirecaoPerigosa = [];
    public $clusterReporteCongestionamentoRecorrente = [];
    public $clusterReportesDrenagemAgua = [];

    public function mount()
    {
        // Asfalto danificado
        $this->clusterReportesAsfaltoDanificado =
            $this->getClusterByCategory('Asfalto danificado');

        // Sinalização deficiente
        $this->clusterReportesSinalizacaoDeficiente =
            $this->getClusterByCategory('Sinalização deficiente');

        // Direção perigosa
        $this->clusterReportesDirecaoPerigosa =
            $this->getClusterByCategory('Direção perigosa');

        // Congestionamento recorrente
        $this->clusterReporteCongestionamentoRecorrente =
            $this->getClusterByCategory('Congestionamento recorrente');

        // Drenagem de água
        $this->clusterReportesDrenagemAgua =
            $this->getClusterByCategory('Drenagem de água');
    }

    /**
     * Retorna latitude/longitude filtrados pela descrição da categoria
     */
    private function getClusterByCategory($nomeCategoria)
    {
        return Reporte::select('latitude', 'longitude')
            ->whereHas('categoria', function ($query) use ($nomeCategoria) {
                $query->where('descricao', $nomeCategoria);
            })
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.clustering-map');
    }
}
