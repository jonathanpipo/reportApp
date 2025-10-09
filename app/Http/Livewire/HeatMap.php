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

    public function mount() {

        //Todos os reportes
        $this->allHeatReportes = Reporte::all(['latitude', 'longitude'])->toArray();
        
        //Asfalto danificado
        $this->heatReportesAsfaltoDanificado = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Asfalto danificado')
            ->get()
            ->toArray();

        //Sinalização deficiente
        $this->heatReportesSinalizacaoDeficiente = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Sinalização deficiente')
            ->get()
            ->toArray();

        //Direção perigosa
        $this->heatReportesDirecaoPerigosa = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Direção perigosa')
            ->get()
            ->toArray();

        //Congestionamento recorrente
        $this->heatReporteCongestionamentoRecorrente = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Congestionamento recorrente')
            ->get()
            ->toArray();
            
        //Drenagem de água
        $this->heatReportesDrenagemAgua = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Drenagem de água')
            ->get()
            ->toArray();    
        }

    public function render()
    {
        return view('livewire.heat-map');
    }
}
