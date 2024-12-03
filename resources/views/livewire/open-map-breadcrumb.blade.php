<div class="breadcrumb">
    {{-- Enlace a la capa inicial de Oaxaca --}}
    <span>
        {{-- Al hacer clic, se ejecuta la función `resetMapLayer` que restablece el mapa a la capa inicial de Oaxaca --}}
        <a href="#" onclick="resetMapLayer(); return false;">OAXACA</a>
    </span>

    {{-- Si hay una región seleccionada y no es 'N/A', se muestra el enlace a la región --}}
    @if ($region && $region !== 'N/A')
        {{-- Se muestra la región en el breadcrumb, con un enlace que ejecuta `resetMapLayerRegion` pasando la región como parámetro --}}
        / <span>
            <a href="#" onclick="resetMapLayerRegion('{{ $region }}'); return false;">{{ $region }}</a>
        </span>
    @endif

    {{-- Si hay un municipio seleccionado y no es 'N/A' o '000', se muestra el municipio --}}
    @if ($municipio && $municipio !== 'N/A' && $municipio !== '000')
        {{-- El municipio se muestra como texto dentro del breadcrumb sin un enlace --}}
        / <span>{{ $municipio }}</span>
    @endif

    {{-- Estilos internos para personalizar la apariencia del breadcrumb --}}
    <style>
        .breadcrumb {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 15px;
        }
        .breadcrumb span {
            font-weight: bold;
        }
        .breadcrumb span a {
            color: #9d2449;
            text-decoration: none;
        }
        .breadcrumb span a:hover {
            text-decoration: underline;
        }
    </style>
</div>

