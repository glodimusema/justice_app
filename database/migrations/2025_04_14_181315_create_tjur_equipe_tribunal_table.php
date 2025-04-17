<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurEquipeTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_equipe_tribunal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_membre')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_tribunal')->constrained('tjur_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->string('fonction_tribunal',250);
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
        Schema::dropIfExists('tjur_equipe_tribunal');
    }
}
