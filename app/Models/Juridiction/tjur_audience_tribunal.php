<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_audience_tribunal extends Model
{
    protected $fillable=['id','id_suivi_tribunal','date_audience','resume_audience','decision_audience','motif_remise_audience','author','refUser'];
    protected $table = 'tjur_audience_tribunal'; 
}



