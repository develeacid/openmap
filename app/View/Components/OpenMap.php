<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OpenMap extends Component
{
    public $mapId;
    public $geoJsonUrl;
    public $center;
    public $zoom;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mapId, $geoJsonUrl, $center, $zoom)
    {
         $this->mapId = $mapId;
         $this->geoJsonUrl = $geoJsonUrl;
         $this->center = $center;
         $this->zoom = $zoom;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.open-map');
    }
}
