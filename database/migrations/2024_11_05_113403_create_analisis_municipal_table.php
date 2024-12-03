<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis_municipal', function (Blueprint $table) {
            $table->id();
            $table->string('mun_id', 10)->unique();
            $table->string('mun_nom', 100);
            $table->integer('pob_tot');
            $table->decimal('sup_km2', 10, 2);
            $table->integer('mun_loc_tot');
            $table->string('reg', 50);
            $table->string('dist', 50);
            $table->integer('pob_18_44');
            $table->integer('pea_tot');
            $table->integer('pea_ocup');
            $table->integer('pea_ocup_inf');
            $table->decimal('pct_pea', 5, 2);
            $table->decimal('pct_ocup_pea', 5, 2);
            $table->decimal('pct_ocup_inf', 5, 2);
            $table->string('loc_princ_1', 100)->nullable();
            $table->string('loc_princ_2', 100)->nullable();
            $table->string('loc_princ_3', 100)->nullable();
            $table->text('sec_princ');
            $table->integer('ue_sec_tot');
            $table->integer('ue_mun_tot');
            $table->integer('pymes_tot');
            $table->string('prod_princ_1', 100)->nullable();
            $table->decimal('vol_gan_1', 10, 2)->nullable();
            $table->string('prod_princ_2', 100)->nullable();
            $table->decimal('vol_gan_2', 10, 2)->nullable();
            $table->string('prod_princ_3', 100)->nullable();
            $table->decimal('vol_gan_3', 10, 2)->nullable();
            $table->string('cult_princ_1', 100)->nullable();
            $table->decimal('vol_agri_1', 10, 2)->nullable();
            $table->string('cult_princ_2', 100)->nullable();
            $table->decimal('vol_agri_2', 10, 2)->nullable();
            $table->string('cult_princ_3', 100)->nullable();
            $table->decimal('vol_agri_3', 10, 2)->nullable();
            $table->integer('viv_tot');
            $table->integer('viv_sin_agua');
            $table->decimal('pct_viv_sin_agua', 5, 2);
            $table->integer('viv_sin_pc');
            $table->decimal('pct_viv_sin_pc', 5, 2);
            $table->integer('viv_sin_dren');
            $table->decimal('pct_viv_sin_dren', 5, 2);
            $table->integer('viv_sin_luz');
            $table->decimal('pct_viv_sin_luz', 5, 2);
            $table->integer('viv_sin_int');
            $table->decimal('pct_viv_sin_int', 5, 2);
            $table->integer('esc_ms_23_24');
            $table->integer('alum_ms_23_24');
            $table->integer('esc_sup_23_24');
            $table->integer('alum_sup_23_24');
            $table->integer('caren_salud');
            $table->integer('caren_seg_soc');
            $table->integer('acceso_alim');
            $table->integer('rez_educ');
            $table->integer('pobreza_multi');
            $table->integer('pobreza_ext');
            $table->integer('pobreza_mod');
            $table->integer('vul_caren_soc');
            $table->integer('vul_ing');
            $table->integer('no_pob_no_vul');
            $table->string('afiliacion_salud', 100)->nullable();
            $table->string('rama_princ_1', 100)->nullable();
            $table->integer('artesanos_tot_1')->nullable();
            $table->string('rama_princ_2', 100)->nullable();
            $table->integer('artesanos_tot_2')->nullable();
            $table->string('rama_princ_3', 100)->nullable();
            $table->integer('artesanos_tot_3')->nullable();
            $table->integer('artesanos_tot_mun')->nullable();
            $table->decimal('vacb', 10, 3);
            $table->decimal('total_ingresos', 10, 3);
            $table->decimal('pct_de_18', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis_municipal');
    }
};
