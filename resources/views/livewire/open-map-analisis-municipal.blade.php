<div>
    @if ($municipioData)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Municipio</th>
                    <th>Nombre</th>
                    <th>Población Total</th>
                    <th>Superficie (km²)</th>
                    <th>Total Localidades</th>
                    <th>Región</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $municipioData->mun_id }}</td>
                    <td>{{ $municipioData->mun_nom }}</td>
                    <td>{{ $municipioData->pob_tot }}</td>
                    <td>{{ $municipioData->sup_km2 }}</td>
                    <td>{{ $municipioData->mun_loc_tot }}</td>
                    <td>{{ $municipioData->reg }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>Selecciona un municipio en el mapa para ver su análisis.</p>
    @endif
</div>
