<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reporte;

class Home extends Component
{
    public $categoria;
    public $avaliacaoInfraestrutura;
    public $latitude;
    public $longitude;
    public $precisao;
    public $descricao;

    // Regras de validação
    protected $rules = [
        'categoria'    => 'required|string|max:255',
        'avaliacaoInfraestrutura' => 'nullable|string|max:255',
        'latitude'     => 'required|numeric|between:-90,90',
        'longitude'    => 'required|numeric|between:-180,180',
        'precisao'     => 'nullable|numeric',
        'descricao'    => 'nullable|string',
    ];

    // Método para salvar os dados no banco
    public function createReporte()
    {
        // Valida os campos
        $dadosValidados = $this->validate();

        // Salva no banco usando a model Reporte
        Reporte::create($dadosValidados);

        // Mensagem de sucesso
        session()->flash('success', 'Reporte cadastrado com sucesso!');

        // Limpa os campos do formulário
        $this->reset();
    }

    public function render()
    {
        return view('livewire.home');
    }
}
