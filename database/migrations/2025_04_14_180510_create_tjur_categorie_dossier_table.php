<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurCategorieDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_categorie_dossier', function (Blueprint $table) {
            $table->id();
            $table->string('nom_categorie_dossier',100);
            $table->string('code_categorie_dossier',100);
            $table->double('duree');
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
        Schema::dropIfExists('tjur_categorie_dossier');
    }
}
