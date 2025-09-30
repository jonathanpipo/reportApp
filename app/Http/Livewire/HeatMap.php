<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class HeatMap extends Component
{

    public $heatReportes = [];

    public function mount() {

        $this->heatReportes = Reporte::all(['latitude', 'longitude'])->toArray();
    }

    public function render()
    {
        return view('livewire.heat-map');
    }
}
