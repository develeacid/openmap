<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AnalisisMunicipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ruta al archivo CSV
        $filePath = database_path('seeders/tabla_final.csv');
        
        // Verificar si el archivo existe
        if (!File::exists($filePath)) {
            echo "El archivo CSV no se encontró en la ruta: $filePath";
            return;
        }

        // Abrir el archivo y leer los datos
        $file = fopen($filePath, 'r');
        $isHeader = true;

        while (($row = fgetcsv($file)) !== FALSE) {
            // Saltar la primera fila (encabezados)
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            DB::table('analisis_municipal')->insert([
                'mun_id' => $row[0],
                'mun_nom' => $row[1],
                'pob_tot' => $this->sanitizeInteger($row[2]),
                'sup_km2' => $this->sanitizeFloat($row[3]),
                'mun_loc_tot' => $this->sanitizeInteger($row[4]),
                'reg' => $row[5],
                'dist' => $row[6],
                'pob_18_44' => $row[7],
                'pea_tot' => $row[8],
                'pea_ocup' => $row[9],
                'pea_ocup_inf' => $row[10],
                'pct_pea' => $row[11],
                'pct_ocup_pea' => $row[12],
                'pct_ocup_inf' => $row[13],
                'loc_princ_1' => $row[14],
                'loc_princ_2' => $row[15],
                'loc_princ_3' => $row[16],
                'sec_princ' => $row[17],
                'ue_sec_tot' => $row[18],
                'ue_mun_tot' => $row[19],
                'pymes_tot' => $row[20],
                'prod_princ_1' => $row[21],
                'vol_gan_1' => $this->sanitizeFloat($row[22]),
                'prod_princ_2' => $row[23],
                'vol_gan_2' => $this->sanitizeFloat($row[24]),
                'prod_princ_3' => $row[25],
                'vol_gan_3' => $this->sanitizeFloat($row[26]),
                'cult_princ_1' => $row[27],
                'vol_agri_1' => $this->sanitizeFloat($row[28]),
                'cult_princ_2' => $row[29],
                'vol_agri_2' => $this->sanitizeFloat($row[30]),
                'cult_princ_3' => $row[31],
                'vol_agri_3' => $this->sanitizeFloat($row[32]),
                'viv_tot' => $row[33],
                'viv_sin_agua' => $row[34],
                'pct_viv_sin_agua' => $row[35],
                'viv_sin_pc' => $row[36],
                'pct_viv_sin_pc' => $row[37],
                'viv_sin_dren' => $row[38],
                'pct_viv_sin_dren' => $row[39],
                'viv_sin_luz' => $row[40],
                'pct_viv_sin_luz' => $row[41],
                'viv_sin_int' => $row[42],
                'pct_viv_sin_int' => $row[43],
                'esc_ms_23_24' => $row[44],
                'alum_ms_23_24' => $row[45],
                'esc_sup_23_24' => $row[46],
                'alum_sup_23_24' => $row[47],
                'caren_salud' => $row[48],
                'caren_seg_soc' => $row[49],
                'acceso_alim' => $row[50],
                'rez_educ' => $row[51],
                'pobreza_multi' => $row[52],
                'pobreza_ext' => $row[53],
                'pobreza_mod' => $row[54],
                'vul_caren_soc' => $row[55],
                'vul_ing' => $row[56],
                'no_pob_no_vul' => $row[57],
                'afiliacion_salud' => $row[58],
                'rama_princ_1' => $row[59],
                'artesanos_tot_1' => !empty($row[60]) ? $row[60] : null,
                'rama_princ_2' => $row[61],
                'artesanos_tot_2' => !empty($row[62]) ? $row[62] : null,
                'rama_princ_3' => $row[63],
                'artesanos_tot_2' => !empty($row[64]) ? $row[64] : null,
                'artesanos_tot_mun' => !empty($row[65]) ? $row[65] : null,
                'vacb' => $row[66],
                'total_ingresos' => $row[67],
                'pct_de_18' => $row[68],
            ]);
        }

        fclose($file);
    }

    // Función para sanitizar enteros
    private function sanitizeInteger($value)
    {
        // Eliminar espacios y verificar si es un número entero
        $value = preg_replace('/\s+/', '', $value);
        return is_numeric($value) ? (int) $value : null;
    }

    // Función para sanitizar flotantes
    private function sanitizeFloat($value)
    {
        // Eliminar espacios y comas, verificar si es un número
        $value = preg_replace('/[,\s]+/', '', $value);
        return is_numeric($value) ? (float) $value : null;
    }
}
