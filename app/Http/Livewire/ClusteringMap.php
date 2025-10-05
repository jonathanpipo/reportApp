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
        //Asfalto danificado
        $this->clusterReportesAsfaltoDanificado = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Asfalto danificado')
            ->get()
            ->toArray();

        //Sinalização deficiente
        $this->clusterReportesSinalizacaoDeficiente = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Sinalização deficiente')
            ->get()
            ->toArray();

        //Direção perigosa
        $this->clusterReportesDirecaoPerigosa = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Direção perigosa')
            ->get()
            ->toArray();

        //Congestionamento recorrente
        $this->clusterReporteCongestionamentoRecorrente = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Congestionamento recorrente')
            ->get()
            ->toArray();
            
        //Drenagem de água
        $this->clusterReportesDrenagemAgua = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'Drenagem de água')
            ->get()
            ->toArray();                        

    }

    public function render()
    {
        return view('livewire.clustering-map');
    }
}
