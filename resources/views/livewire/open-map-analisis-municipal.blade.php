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

        <div class="mt-4 space-y-8">
            <!-- Datos Generales -->
            <section>
                <h3 class="font-semibold text-xl">Datos Generales</h3>
                <ul>
                    <li><strong>ID:</strong> {{ $municipioData->mun_id }}</li>
                    <li><strong>Población Total:</strong> {{ number_format($municipioData->pob_tot) }}</li>
                    <li><strong>Superficie (km²):</strong> {{ number_format($municipioData->sup_km2, 2) }}</li>
                    <li><strong>Número de Localidades:</strong> {{ $municipioData->mun_loc_tot }}</li>
                    <li><strong>Región:</strong> {{ $municipioData->reg }}</li>
                    <li><strong>Distrito:</strong> {{ $municipioData->dist }}</li>
                    <li><strong>Población 18-44:</strong> {{ number_format($municipioData->pob_18_44) }}</li>
                </ul>
            </section>

            <!-- Economía y Empleo -->
            <section>
                <h3 class="font-semibold text-xl">Economía y Empleo</h3>
                <ul>
                    <li><strong>PEA Total:</strong> {{ number_format($municipioData->pea_tot) }}</li>
                    <li><strong>PEA Ocupada:</strong> {{ number_format($municipioData->pea_ocup) }}</li>
                    <li><strong>PEA Ocupada Informal:</strong> {{ number_format($municipioData->pea_ocup_inf) }}</li>
                    <li><strong>% PEA:</strong> {{ $municipioData->pct_pea }}%</li>
                    <li><strong>% PEA Ocupada:</strong> {{ $municipioData->pct_ocup_pea }}%</li>
                    <li><strong>% PEA Informal:</strong> {{ $municipioData->pct_ocup_inf }}%</li>
                </ul>
            </section>

            <!-- Vivienda -->
            <section>
                <h3 class="font-semibold text-xl">Vivienda</h3>
                <ul>
                    <li><strong>Viviendas Totales:</strong> {{ number_format($municipioData->viv_tot) }}</li>
                    <li><strong>Sin Agua:</strong> {{ $municipioData->viv_sin_agua }} ({{ $municipioData->pct_viv_sin_agua }}%)</li>
                    <li><strong>Sin Drenaje:</strong> {{ $municipioData->viv_sin_dren }} ({{ $municipioData->pct_viv_sin_dren }}%)</li>
                    <li><strong>Sin Luz:</strong> {{ $municipioData->viv_sin_luz }} ({{ $municipioData->pct_viv_sin_luz }}%)</li>
                    <li><strong>Sin Internet:</strong> {{ $municipioData->viv_sin_int }} ({{ $municipioData->pct_viv_sin_int }}%)</li>
                </ul>
            </section>

            <!-- Educación -->
            <section>
                <h3 class="font-semibold text-xl">Educación</h3>
                <ul>
                    <li><strong>Escuelas Media Superior (23-24):</strong> {{ $municipioData->esc_ms_23_24 }}</li>
                    <li><strong>Alumnos Media Superior (23-24):</strong> {{ $municipioData->alum_ms_23_24 }}</li>
                    <li><strong>Escuelas Superior (23-24):</strong> {{ $municipioData->esc_sup_23_24 }}</li>
                    <li><strong>Alumnos Superior (23-24):</strong> {{ $municipioData->alum_sup_23_24 }}</li>
                </ul>
            </section>

            <!-- Producción y Artesanías -->
            <section>
                <h3 class="font-semibold text-xl">Producción y Artesanías</h3>
                <ul>
                    <li><strong>Producto Principal 1:</strong> {{ $municipioData->prod_princ_1 }} ({{ $municipioData->vol_gan_1 }} unidades)</li>
                    <li><strong>Producto Principal 2:</strong> {{ $municipioData->prod_princ_2 }} ({{ $municipioData->vol_gan_2 }} unidades)</li>
                    <li><strong>Producto Principal 3:</strong> {{ $municipioData->prod_princ_3 }} ({{ $municipioData->vol_gan_3 }} unidades)</li>
                    <li><strong>Artesanos Totales:</strong> {{ number_format($municipioData->artesanos_tot_mun) }}</li>
                </ul>
            </section>

            <!-- Salud y Pobreza -->
            <section>
                <h3 class="font-semibold text-xl">Salud y Pobreza</h3>
                <ul>
                    <li><strong>Carencias de Salud:</strong> {{ $municipioData->caren_salud }}</li>
                    <li><strong>Carencias Sociales:</strong> {{ $municipioData->caren_seg_soc }}</li>
                    <li><strong>Pobreza Multidimensional:</strong> {{ $municipioData->pobreza_multi }}</li>
                    <li><strong>Pobreza Extrema:</strong> {{ $municipioData->pobreza_ext }}</li>
                    <li><strong>Pobreza Moderada:</strong> {{ $municipioData->pobreza_mod }}</li>
                </ul>
            </section>
        </div>
    @endif
</div>
