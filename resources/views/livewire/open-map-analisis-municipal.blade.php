<div>
    <h1>Información del Municipio</h1>

    @if ($municipioId === 'N/A')
        <p>Seleccione un municipio en el mapa para ver información.</p>
    @elseif (!$isDataLoaded)
        <p>Cargando información del municipio...</p>
    @elseif ($municipioData === null)
        <p>No se encontraron datos para el municipio seleccionado.</p>
    @else
        <h2 class="text-lg font-bold">Información del Municipio: {{ $municipioData->mun_nom }}</h2>
        
        <!-- Pestañas -->
        <ul class="nav nav-tabs mt-4" id="municipioTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="generales-tab" data-bs-toggle="tab" data-bs-target="#generales" type="button" role="tab" aria-controls="generales" aria-selected="true">
                    Datos Generales
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="economia-tab" data-bs-toggle="tab" data-bs-target="#economia" type="button" role="tab" aria-controls="economia" aria-selected="false">
                    Economía y Empleo
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="vivienda-tab" data-bs-toggle="tab" data-bs-target="#vivienda" type="button" role="tab" aria-controls="vivienda" aria-selected="false">
                    Vivienda
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="educacion-tab" data-bs-toggle="tab" data-bs-target="#educacion" type="button" role="tab" aria-controls="educacion" aria-selected="false">
                    Educación
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="produccion-tab" data-bs-toggle="tab" data-bs-target="#produccion" type="button" role="tab" aria-controls="produccion" aria-selected="false">
                    Producción y Artesanías
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="salud-tab" data-bs-toggle="tab" data-bs-target="#salud" type="button" role="tab" aria-controls="salud" aria-selected="false">
                    Salud y Pobreza
                </button>
            </li>
        </ul>

        <!-- Contenido de las Pestañas -->
        <div class="tab-content mt-3" id="municipioTabsContent">
            <!-- Datos Generales -->
            <div class="tab-pane fade show active" id="generales" role="tabpanel" aria-labelledby="generales-tab">
                <ul>
                    <li><strong>ID:</strong> {{ $municipioData->mun_id }}</li>
                    <li><strong>Población Total:</strong> {{ number_format($municipioData->pob_tot) }}</li>
                    <li><strong>Superficie (km²):</strong> {{ number_format($municipioData->sup_km2, 2) }}</li>
                    <li><strong>Número de Localidades:</strong> {{ $municipioData->mun_loc_tot }}</li>
                    <li><strong>Región:</strong> {{ $municipioData->reg }}</li>
                    <li><strong>Distrito:</strong> {{ $municipioData->dist }}</li>
                </ul>
            </div>

            <!-- Economía y Empleo -->
            <div class="tab-pane fade" id="economia" role="tabpanel" aria-labelledby="economia-tab">
                <ul>
                    <li><strong>PEA Total:</strong> {{ number_format($municipioData->pea_tot) }}</li>
                    <li><strong>PEA Ocupada:</strong> {{ number_format($municipioData->pea_ocup) }}</li>
                    <li><strong>PEA Ocupada Informal:</strong> {{ number_format($municipioData->pea_ocup_inf) }}</li>
                    <li><strong>% PEA:</strong> {{ $municipioData->pct_pea }}%</li>
                    <li><strong>% PEA Ocupada:</strong> {{ $municipioData->pct_ocup_pea }}%</li>
                    <li><strong>% PEA Informal:</strong> {{ $municipioData->pct_ocup_inf }}%</li>
                </ul>
            </div>

            <!-- Vivienda -->
            <div class="tab-pane fade" id="vivienda" role="tabpanel" aria-labelledby="vivienda-tab">
                <ul>
                    <li><strong>Viviendas Totales:</strong> {{ number_format($municipioData->viv_tot) }}</li>
                    <li><strong>Sin Agua:</strong> {{ $municipioData->viv_sin_agua }} ({{ $municipioData->pct_viv_sin_agua }}%)</li>
                    <li><strong>Sin Drenaje:</strong> {{ $municipioData->viv_sin_dren }} ({{ $municipioData->pct_viv_sin_dren }}%)</li>
                    <li><strong>Sin Luz:</strong> {{ $municipioData->viv_sin_luz }} ({{ $municipioData->pct_viv_sin_luz }}%)</li>
                    <li><strong>Sin Internet:</strong> {{ $municipioData->viv_sin_int }} ({{ $municipioData->pct_viv_sin_int }}%)</li>
                </ul>
            </div>

            <!-- Educación -->
            <div class="tab-pane fade" id="educacion" role="tabpanel" aria-labelledby="educacion-tab">
                <ul>
                    <li><strong>Escuelas Media Superior (23-24):</strong> {{ $municipioData->esc_ms_23_24 }}</li>
                    <li><strong>Alumnos Media Superior (23-24):</strong> {{ $municipioData->alum_ms_23_24 }}</li>
                    <li><strong>Escuelas Superior (23-24):</strong> {{ $municipioData->esc_sup_23_24 }}</li>
                    <li><strong>Alumnos Superior (23-24):</strong> {{ $municipioData->alum_sup_23_24 }}</li>
                </ul>
            </div>

            <!-- Producción y Artesanías -->
            <div class="tab-pane fade" id="produccion" role="tabpanel" aria-labelledby="produccion-tab">
                <ul>
                    <li><strong>Producto Principal 1:</strong> {{ $municipioData->prod_princ_1 }} ({{ $municipioData->vol_gan_1 }} unidades)</li>
                    <li><strong>Producto Principal 2:</strong> {{ $municipioData->prod_princ_2 }} ({{ $municipioData->vol_gan_2 }} unidades)</li>
                    <li><strong>Producto Principal 3:</strong> {{ $municipioData->prod_princ_3 }} ({{ $municipioData->vol_gan_3 }} unidades)</li>
                    <li><strong>Artesanos Totales:</strong> {{ number_format($municipioData->artesanos_tot_mun) }}</li>
                </ul>
            </div>

            <!-- Salud y Pobreza -->
            <div class="tab-pane fade" id="salud" role="tabpanel" aria-labelledby="salud-tab">
                <ul>
                    <li><strong>Carencias de Salud:</strong> {{ $municipioData->caren_salud }}</li>
                    <li><strong>Pobreza Multidimensional:</strong> {{ $municipioData->pobreza_multi }}</li>
                    <li><strong>Pobreza Extrema:</strong> {{ $municipioData->pobreza_ext }}</li>
                </ul>
            </div>
        </div>
    @endif
</div>
