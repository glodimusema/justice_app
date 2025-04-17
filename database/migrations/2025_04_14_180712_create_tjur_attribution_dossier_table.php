<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurAttributionDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_attribution_dossier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_dossier')->constrained('tjur_dossier')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_affectation_jur')->constrained('tjur_affect_juridiction')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_map');            
            $table->string('avocat_plaignant',100);
            $table->string('avocat_inculpe',100);
            $table->text('rapport_enquete');
            $table->string('decision_statut',100)->default('Arreté');            
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
        Schema::dropIfExists('tjur_attribution_dossier');
    }
}
