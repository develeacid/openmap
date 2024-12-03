@extends('layouts.openmap')

@section('content')
<div class="col-md-12">
    <h1>Bienvenido a mi componente de Open Layer</h1>

    {{-- Componente de mapa con controles --}}
    <div class="col-12" style="height: 80vh;"> <!-- Asegúrate de que este div tenga una altura adecuada -->
        <!-- Aquí se carga el mapa con controles, ajustado al contenedor -->
        <x-open-map-with-controllers 
            mapId="maping" 
            geoJsonUrl="{{ asset('GeoJson/Regiones.geojson') }}" 
            :center="[-100, 20]" 
            :zoom="4" 
            :breadcrumb="true" /> <!-- Este estilo asegura que el mapa ocupe el 100% del contenedor -->
    </div>
</div>
@endsection
