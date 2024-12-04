<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisMunicipal extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'analisis_municipal';

    protected $fillable = ['mun_id','mun_nom','pob_tot','sup_km2','mun_loc_tot','reg','dist','pob_18_44','pea_tot','pea_ocup','pea_ocup_inf','pct_pea','pct_ocup_pea','pct_ocup_inf','loc_princ_1','loc_princ_2','loc_princ_3','sec_princ','ue_sec_tot','ue_mun_tot','pymes_tot','prod_princ_1','vol_gan_1','prod_princ_2','vol_gan_2','prod_princ_3','vol_gan_3','cult_princ_1','vol_agri_1','cult_princ_2','vol_agri_2','cult_princ_3','vol_agri_3','viv_tot','viv_sin_agua','pct_viv_sin_agua','viv_sin_pc','pct_viv_sin_pc','viv_sin_dren','pct_viv_sin_dren','viv_sin_luz','pct_viv_sin_luz','viv_sin_int','pct_viv_sin_int','esc_ms_23_24','alum_ms_23_24','esc_sup_23_24','alum_sup_23_24','caren_salud','caren_seg_soc','acceso_alim','rez_educ','pobreza_multi','pobreza_ext','pobreza_mod','vul_caren_soc','vul_ing','no_pob_no_vul','afiliacion_salud','rama_princ_1','artesanos_tot_1','rama_princ_2','artesanos_tot_2','rama_princ_3','artesanos_tot_3','artesanos_tot_mun','vacb','total_ingresos','pct_de_18'];
	
}
