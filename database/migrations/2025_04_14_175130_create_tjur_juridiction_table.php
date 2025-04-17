<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurJuridictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_juridiction', function (Blueprint $table) {
            $table->id();
            $table->string('nom_jur',100);
            $table->string('code_jur',100);
            $table->foreignId('id_type_jur')->constrained('tjur_type_juridiction')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_categorie_jur')->constrained('tjur_categorie_juridiction')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tjur_juridiction');
    }
}
