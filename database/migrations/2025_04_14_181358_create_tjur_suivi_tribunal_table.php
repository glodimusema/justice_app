<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurSuiviTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_suivi_tribunal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tribunal')->constrained('tjur_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_liberte');
            $table->date('date_prononce');
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
        Schema::dropIfExists('tjur_suivi_tribunal');
    }
}
