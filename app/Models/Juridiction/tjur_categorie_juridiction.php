<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_categorie_juridiction extends Model
{
    protected $fillable=['id','nom_categorie_jur'];
    protected $table = 'tjur_categorie_juridiction';   

}



