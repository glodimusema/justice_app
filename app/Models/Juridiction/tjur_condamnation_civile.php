<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_condamnation_civile extends Model
{
    protected $fillable=['id','id_suivi_tribunal','decision_principale','decision_subsidiaire',
    'commandement_civil','date_execution_civil','montant_civil','author','refUser'];
    protected $table = 'tjur_condamnation_civile'; 
}



