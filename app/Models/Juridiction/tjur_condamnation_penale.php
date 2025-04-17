<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_condamnation_penale extends Model
{
    protected $fillable=['id','id_suivi_tribunal','SP_duree','montant_amende','montant_SPS',
'CPC_duree','montant_domage','date_signification','requisition_fin','req_emprisonnement',
'mandat_prise_corps','commandement','montant_cmd','numero_bordereau_cmd','date_opposition',
'date_appel','date_revision','date_prise_partie','author','refUser'];
    protected $table = 'tjur_condamnation_penale'; 



    

}



