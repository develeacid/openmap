@extends('layouts.openmap')

@section('content')
    <h1>Bienvenido a mi componente de Open Layer</h1>
    {{--
    solo mapa
    <x-open-map mapId="maping" geoJsonUrl="{{ asset('GeoJson/Regiones.geojson') }}" :center="[-100, 20]" :zoom="4" />
    --}}
    {{--
    whith controllers
    --}}
    <x-open-map-with-controllers mapId="maping" geoJsonUrl="{{ asset('GeoJson/Regiones.geojson') }}" :center="[-100, 20]" :zoom="4" :breadcrumb="true" />
@endsection