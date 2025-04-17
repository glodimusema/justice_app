<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_arrestation extends Model
{
    protected $fillable=['id','id_attribution_jur','date_arretation','motif_arrestation',
'statut_map','statut_odp','oc1','oc2','oc3','date_fin_oc1','date_fin_oc2','date_fin_oc3',
'date_relaxe','date_requete_liberte','date_liberte_provisoire','montant_liberte_prov',
'bordereau_liberte_prov','date_classement','motif_classement','date_envoie_fixation',
'statut_arrestation','author','refUser'];
    protected $table = 'tjur_arrestation'; 

}



