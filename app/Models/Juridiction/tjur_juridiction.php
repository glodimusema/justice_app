<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_juridiction extends Model
{
    protected $fillable=['id','nom_jur','code_jur','id_type_jur','id_categorie_jur'];
    protected $table = 'tjur_juridiction'; 
}



