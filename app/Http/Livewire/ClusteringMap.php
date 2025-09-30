<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class ClusteringMap extends Component
{

     public $clusterReportesInfraestrutura = [];
     public $clusterReportesSinalizacao = [];
     public $clusterReportesSituacao = [];

     public function mount()
    {
        //infraestrutura
        $this->clusterReportesInfraestrutura = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'infraestrutura')
            ->get()
            ->toArray();

        //situação
        $this->clusterReportesSituacao = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'situação')
            ->get()
            ->toArray();


        //sinalização
        $this->clusterReportesSinalizacao = Reporte::select('categoria', 'latitude', 'longitude')
            ->where('categoria', 'sinalização')
            ->get()
            ->toArray();

    }

    public function render()
    {
        return view('livewire.clustering-map');
    }
}
