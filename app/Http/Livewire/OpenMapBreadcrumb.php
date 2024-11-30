<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OpenMapBreadcrumb extends Component
{
    public $region = 'N/A';
    public $municipio = 'N/A';

    protected $listeners = ['mapClick' => 'updateBreadcrumb' , 'breadcrumbReset'];

    public function updateBreadcrumb($data)
    {
        $this->region = $data['region'];
        $this->municipio = $data['cveMun'];
    }

    public function breadcrumbReset()
    {
        $this->region = null;
        $this->municipio = null;
    }
    
    public function render()
    {
        return view('livewire.open-map-breadcrumb');
    }
}
