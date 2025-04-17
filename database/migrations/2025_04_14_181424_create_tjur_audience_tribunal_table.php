<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurAudienceTribunalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_audience_tribunal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_suivi_tribunal')->constrained('tjur_suivi_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_audience');
            $table->text('resume_audience');
            $table->text('decision_audience');
            $table->text('motif_remise_audience');
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
        Schema::dropIfExists('tjur_audience_tribunal');
    }
}
