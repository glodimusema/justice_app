<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_attribution_dossier extends Model
{
    protected $fillable=['id','id_dossier','id_affectation_jur','date_map',
    'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut','author','refUser'];
    protected $table = 'tjur_attribution_dossier'; 
}



