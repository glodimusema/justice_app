<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_dossier extends Model
{
    protected $fillable=['id','date_ouverture','objets_dossier','id_categorie_dossier',
    'id_plaignant','id_inculpe','author','refUser'];
    protected $table = 'tjur_dossier'; 

}



