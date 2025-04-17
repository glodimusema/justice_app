<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurCondamnationPenaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_condamnation_penale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_suivi_tribunal')->constrained('tjur_suivi_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->double('SP_duree');
            $table->double('montant_amende');
            $table->double('montant_SPS');
            $table->double('CPC_duree');
            $table->double('montant_domage');
            $table->date('date_signification');
            $table->string('requisition_fin',250)->nullable();
            $table->string('req_emprisonnement',250)->nullable();
            $table->string('mandat_prise_corps',250)->nullable();
            $table->string('commandement',250)->nullable();
            $table->double('montant_cmd')->nullable();
            $table->string('numero_bordereau_cmd',250)->nullable();
            

            $table->date('date_opposition')->nullable();
            $table->date('date_appel')->nullable();
            $table->date('date_revision')->nullable();
            $table->date('date_prise_partie')->nullable();

            $table->string('author',100)->nullable();
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
        Schema::dropIfExists('tjur_condamnation_penale');
    }
}
