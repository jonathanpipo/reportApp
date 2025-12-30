<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;
use App\Models\Categoria;

class Home extends Component
{
    public $categorias;
    public $categoria_id;
    public $avaliacao;
    public $latitude;
    public $longitude;
    public $comentario;

    protected $rules = [
        'categoria_id' => 'required|integer|exists:categorias,id',
        'avaliacao'    => 'required|string|max:100',
        'latitude'     => 'required|numeric|between:-90,90',
        'longitude'    => 'required|numeric|between:-180,180',
        'comentario'   => 'nullable|string|max:200',
    ];

    public function mount()
    {
        $this->categorias = Categoria::all();
    }

    public function createReporte()
    {
        $dadosValidados = $this->validate();

        Reporte::create($dadosValidados);

        // Mensagem flash
        session()->flash('success', 'Seu reporte foi enviado com sucesso!');

        // Limpa campos
        $this->reset(['categoria_id', 'avaliacao', 'latitude', 'longitude', 'comentario']);

        // Dispara evento para subir o scroll
        $this->dispatch('scroll-top');
    }


    public function render()
    {
        return view('livewire.home');
    }
}
