<div>
<div>
    <input type="hidden" id="geojson_url" value="{{ asset('oaxacaGeoJson.json') }}">
    <input type="hidden" id="geojson_url2" value="{{ asset('oaxaca8Regiones.json') }}">
    <div id="map" wire:ignore style="width: 100%; height: 400px;"></div>
</div>
    

<script>
    let mapInitialized = false;  // Flag to track initialization

    document.addEventListener('livewire:load', function () {
        if (!mapInitialized) {
            inicializarMapa('map', '{{ asset('GeoJson/municipios/001.geojson') }}', '{{ asset('GeoJson/Municipios.json') }}'); // Pasar ambas URLs
            mapInitialized = true;
        }
    });
</script>
</div>