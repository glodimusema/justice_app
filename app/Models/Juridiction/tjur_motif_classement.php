<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_motif_classement extends Model
{
    protected $fillable=['id','nom_motif'];
    protected $table = 'tjur_motif_classement'; 
}



