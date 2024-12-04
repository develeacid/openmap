<?php

namespace App\Http\Livewire;
use App\Models\AnalisisMunicipal;

use Livewire\Component;

class OpenMapAnalisisMunicipal extends Component
{
    public $municipioId = 'N/A';
    public $municipioData = null; // Aquí se almacenarán los datos del municipio

    protected $listeners = ['mapClick' => 'updateMunicipio'];

    public function updateMunicipio($data)
    {
        $this->municipioId = $data['cveMun'] ?? 'N/A';

        if ($this->municipioId !== 'N/A') {
            $this->municipioData = AnalisisMunicipal::where('mun_id', $this->municipioId)->first();
        } else {
            $this->municipioData = null;
        }
    }

    public function render()
    {
        return view('livewire.open-map-analisis-municipal', [
            'municipioData' => $this->municipioData,
        ]);
    }
}
