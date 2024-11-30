<div class="breadcrumb">
    <span>OAXACA</span>
    @if($region !== 'N/A')
        / <span>{{ $region }}</span>
    @endif
    @if($municipio !== 'N/A' && $municipio !== '000')
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
    </style>
</div>

