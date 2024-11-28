@extends('layouts.openmap')

@section('content')
    <h1>Bienvenido a mi componente de Open Layer</h1>
    <x-open-map mapId="maping" geoJsonUrl="{{ asset('GeoJson/regionales/CAÑADA.geojson') }}" :center="[-100, 20]" :zoom="4" />
@endsection