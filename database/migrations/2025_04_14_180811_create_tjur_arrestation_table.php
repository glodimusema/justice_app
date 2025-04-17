<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurArrestationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_arrestation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_attribution_jur')->constrained('tjur_attribution_dossier')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_arretation');            
            $table->text('motif_arrestation');
            $table->string('statut_map',100); 
            $table->string('statut_odp',100);
            $table->double('oc1');
            $table->double('oc2');
            $table->double('oc3'); 
            $table->date('date_fin_oc1');
            $table->date('date_fin_oc2');
            $table->date('date_fin_oc3');

            $table->date('date_relaxe')->nullable();
            $table->date('date_requete_liberte')->nullable();
            $table->date('date_liberte_provisoire')->nullable();

            $table->double('montant_liberte_prov')->nullable();
            $table->string('bordereau_liberte_prov',100)->nullable();

            $table->date('date_classement')->nullable();
            $table->string('motif_classement',250)->nullable();

            $table->date('date_envoie_fixation')->nullable();

            $table->string('statut_arrestation',100)->default('Liberté provisoire');            
            $table->string('author',100);
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tjur_arrestation');
    }
}
