<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_annexe_dossier extends Model
{
    protected $fillable=['id','noms_annexe','id_dossier','annexe','author'];
    protected $table = 'tjur_annexe_dossier'; 
}



