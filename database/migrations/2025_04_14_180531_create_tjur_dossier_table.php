<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTjurDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tjur_dossier', function (Blueprint $table) {
            $table->id();
            $table->date('date_ouverture');
            $table->text('objets_dossier');
            $table->foreignId('id_categorie_dossier')->constrained('tjur_categorie_dossier')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_plaignant')->constrained('tvente_fournisseur')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_inculpe')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tjur_dossier');
    }
}
