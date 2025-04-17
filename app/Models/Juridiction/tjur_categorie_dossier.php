<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_categorie_dossier extends Model
{
    protected $fillable=['id','nom_categorie_dossier','code_categorie_dossier','duree'];
    protected $table = 'tjur_categorie_dossier'; 
}



