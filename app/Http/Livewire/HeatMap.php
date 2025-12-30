<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class HeatMap extends Component
{
    public $heatReportesAsfaltoDanificado = [];
    public $heatReportesSinalizacaoDeficiente = [];
    public $heatReportesDirecaoPerigosa = [];
    public $heatReporteCongestionamentoRecorrente = [];
    public $heatReportesDrenagemAgua = [];
    public $allHeatReportes = [];

    public function mount()
    {
        // Todos os reportes (sem filtrar categoria)
        $this->allHeatReportes = Reporte::select('latitude', 'longitude')
            ->get()
            ->toArray();

        // Filtros individuais por nome de categoria
        $this->heatReportesAsfaltoDanificado =
            $this->getHeatByCategory('Asfalto danificado');

        $this->heatReportesSinalizacaoDeficiente =
            $this->getHeatByCategory('Sinalização deficiente');

        $this->heatReportesDirecaoPerigosa =
            $this->getHeatByCategory('Direção perigosa');

        $this->heatReporteCongestionamentoRecorrente =
            $this->getHeatByCategory('Congestionamento recorrente');

        $this->heatReportesDrenagemAgua =
            $this->getHeatByCategory('Drenagem de água');
    }

    /**
     * Retorna latitude/longitude filtrados pelo nome da categoria
     */
    private function getHeatByCategory($nomeCategoria)
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
        return view('livewire.heat-map');
    }
}
