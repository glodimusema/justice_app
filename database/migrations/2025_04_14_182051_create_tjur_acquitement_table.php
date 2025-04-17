<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurAcquitementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_acquitement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_suivi_tribunal')->constrained('tjur_suivi_tribunal')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_acquitement');
            $table->text('mondat_elargissement')->nullable();
            $table->date('jour_liberation');
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
        Schema::dropIfExists('tjur_acquitement');
    }
}
