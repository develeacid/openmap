<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OpenMapWithControllers extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $mapId;
    public $geoJsonUrl;
    public $center;
    public $zoom;
    public $breadcrumb;

    public function __construct($mapId, $geoJsonUrl, $center, $zoom, $breadcrumb = false)
    {
        $this->mapId = $mapId;
        $this->geoJsonUrl = $geoJsonUrl;
        $this->center = $center;
        $this->zoom = $zoom;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.open-map-with-controllers');
    }
}
