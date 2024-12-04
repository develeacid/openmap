<?php

namespace App\Http\Livewire;
use App\Models\AnalisisMunicipal;

use Livewire\Component;

class OpenMapAnalisisMunicipal extends Component
{
    public $municipioId = 'N/A'; // ID del municipio seleccionado, inicializado en 'N/A'
    public $municipioData = null; // Aquí se almacenarán los datos del municipio cargados
    public $isDataLoaded = false; // Indicador para verificar si los datos del municipio han sido cargados

    // Definir el listener para escuchar el evento 'mapClick' emitido desde el mapa
    protected $listeners = ['mapClick' => 'updateMunicipio'];

    // Método que se ejecuta cuando el mapa es clickeado
    public function updateMunicipio($data)
    {
        // Actualizar el ID del municipio con la clave que recibe desde el evento del mapa
        $this->municipioId = $data['cveMun'] ?? 'N/A'; // Si no hay clave, se mantiene como 'N/A'

        if ($this->municipioId !== 'N/A') {
            // Si el municipio es válido (ID distinto de 'N/A'), marca los datos como cargados
            $this->isDataLoaded = true;

            // Obtiene los datos del municipio desde la base de datos, buscando por su ID
            $this->municipioData = AnalisisMunicipal::where('mun_id', $this->municipioId)->first();
        } else {
            // Si no se seleccionó un municipio, marca los datos como no cargados
            $this->isDataLoaded = false;
            $this->municipioData = null; // No hay datos del municipio
        }
    }

    // Método para renderizar la vista y pasarle los datos a la vista
    public function render()
    {
        // Se pasa a la vista los datos del municipio solo si se han cargado correctamente
        return view('livewire.open-map-analisis-municipal', [
            'municipioData' => $this->isDataLoaded ? $this->municipioData : null, // Si los datos están cargados, se envían a la vista
        ]);
    }
}
