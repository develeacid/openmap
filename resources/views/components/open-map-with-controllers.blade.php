{{--
    Este es el componente que maneja el mapa con controles adicionales como el breadcrumb y el botón de restablecer.
    Dependiendo de la lógica proporcionada, puede mostrar o no el breadcrumb y otros elementos de la interfaz.
--}}

<div class="container mt-4"> {{-- Contenedor principal con un margen superior de 4 unidades. --}}

    {{-- Verifica si la variable 'breadcrumb' está habilitada y, si es así, muestra el componente del breadcrumb --}}
    @if ($breadcrumb) {{-- Mostrar breadcrumb si está habilitado --}}
        <div> {{-- Contenedor para el breadcrumb --}}
            {{-- El componente Livewire 'open-map-breadcrumb' se incluye aquí para mostrar la información de la región y municipio --}}
            <livewire:open-map-breadcrumb />
        </div>
    @endif

    {{-- Componente del mapa: Se pasa la URL del archivo GeoJSON, las coordenadas del centro y el nivel de zoom --}}
    <x-open-map :mapId="$mapId" :geoJsonUrl="$geoJsonUrl" :center="$center" :zoom="$zoom"/>

    {{-- Componente de botón para restablecer el mapa a su estado inicial --}}
    <x-open-map-button-reset />

    <!-- Incluir el componente Livewire para mostrar la información -->
        <livewire:open-map-analisis-municipal />

</div>
