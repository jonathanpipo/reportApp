<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class DataMaps extends Component
{

    public $heatReportes = [];

    public $clusterReportes = [];
    public $categorias = [];
    public $categoriaSelecionada = null;
    

    public function mount()
    {
        
        $this->heatReportes = Reporte::all(['latitude', 'longitude'])->toArray();


        $this->clusterReportes = Reporte::select('categoria','latitude','longitude')->get()->toArray();

        $this->categorias = collect($this->clusterReportes)->pluck('categoria')->unique()->toArray();

        
    }

    public function selecionarCategoria($categoria)
    {
        // Filtra os reportes por categoria selecionada
        $this->categoriaSelecionada = $categoria;
    }

    public function render()
    {
        // Se categoriaSelecionada estiver setada, filtra reportes
        $reportesFiltrados = $this->categoriaSelecionada
            ? array_filter($this->clusterReportes, fn($r) => $r['categoria'] === $this->categoriaSelecionada)
            : $this->clusterReportes;

        return view('livewire.data-maps', [
            'reportesFiltrados' => $reportesFiltrados
        ]);
    }


}
