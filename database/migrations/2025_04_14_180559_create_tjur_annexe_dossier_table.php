<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurAnnexeDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_annexe_dossier', function (Blueprint $table) {
            $table->id();
            $table->string('noms_annexe');
            $table->foreignId('id_dossier')->constrained('tjur_dossier')->restrictOnUpdate()->restrictOnDelete();
            $table->string('annexe');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user');
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
        Schema::dropIfExists('tjur_annexe_dossier');
    }
}
