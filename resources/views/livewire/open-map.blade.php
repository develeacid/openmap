<div>
<div id="map" style="height: 400px; width: 100%;"></div> {{-- Ensure inline styles for height/width --}}
    

<script>
    let mapInitialized = false;  // Flag to track initialization

    document.addEventListener('livewire:load', function () {
        if (!mapInitialized) {
            inicializarMapa('map', '{{ asset('oaxacaGeoJson.json') }}');
            mapInitialized = true;
        }
    });
</script>
</div>