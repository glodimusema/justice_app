<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_tribunal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_president')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_arrestation')->constrained('tjur_arrestation')->restrictOnUpdate()->restrictOnDelete();
            $table->string('accompagne1',250);
            $table->string('fonction1',250);
            $table->string('accompagne2',250);
            $table->string('fonction2',250);
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
        Schema::dropIfExists('tjur_tribunal');
    }
}
