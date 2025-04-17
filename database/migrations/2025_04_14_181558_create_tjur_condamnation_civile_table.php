<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurCondamnationCivileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_condamnation_civile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_suivi_tribunal')->constrained('tjur_suivi_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->text('decision_principale');
            $table->text('decision_subsidiaire');
            $table->date('date_execution_civil');
            $table->double('montant_civil')->nullable();
            $table->text('commandement_civil')->nullable();
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
        Schema::dropIfExists('tjur_condamnation_civile');
    }
}
