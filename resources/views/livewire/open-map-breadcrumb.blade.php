<div class="breadcrumb">
    <span>
        <a href="#" onclick="resetMapLayer(); return false;">OAXACA</a>
    </span>
    @if ($region && $region !== 'N/A')
        / <span>
            <a href="#" onclick="updateLayerToRegion('{{ $region }}'); return false;">{{ $region }}</a>
        </span>
    @endif
    @if ($municipio && $municipio !== 'N/A' && $municipio !== '000')
        / <span>{{ $municipio }}</span>
    @endif
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

