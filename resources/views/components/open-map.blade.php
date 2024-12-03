{{-- 
    Este es el componente de mapa. Recibe las siguientes propiedades:
    - $mapId: Identificador único para el mapa. Se usa para generar un id de contenedor único para cada mapa.
    - $geoJsonUrl: URL del archivo GeoJSON que se cargará en el mapa. Este archivo contiene los datos geoespaciales que se visualizarán en el mapa.
    - $center: Coordenadas de latitud y longitud para centrar el mapa cuando se carga.
    - $zoom: Nivel de zoom inicial del mapa.

    El mapa se inicializa usando la función 'inicializarMapa' que se ejecuta cuando el DOM ha sido completamente cargado.
--}}
<div id="openmap-container" style="position: relative;"> 
    
    <div id="map-{{ $mapId }}" style="height: 400px;" ></div>  {{-- Contenedor del mapa con un ID único generado a partir de $mapId. La altura del mapa está fijada a 400px. --}}

</div>

<script>
    // Cuando el DOM esté completamente cargado, se ejecuta el siguiente script para inicializar el mapa.
    document.addEventListener('DOMContentLoaded', function () {
        // Llamada a la función 'inicializarMapa' que toma el ID del mapa, la URL del GeoJSON, las coordenadas de centro y el nivel de zoom.
        inicializarMapa('map-{{ $mapId }}', '{{ $geoJsonUrl }}', {{ json_encode($center) }}, {{ $zoom }});
    });
</script>
