<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurAffectJuridictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_affect_juridiction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_juridiction')->constrained('tjur_juridiction')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_ville')->constrained('villes')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tjur_affect_juridiction');
    }
}
