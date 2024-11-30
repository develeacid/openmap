<div>
  <livewire:open-map-breadcrumb />
    <div id="map-{{ $mapId }}" style="height: 400px; width: 100%;"></div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
          // Llama a la función global inicializarMapa una vez que el DOM esté listo
          inicializarMapa('map-{{ $mapId }}', '{{ $geoJsonUrl }}', {{ json_encode($center) }}, {{ $zoom }});
      });

    </script>
</div>

