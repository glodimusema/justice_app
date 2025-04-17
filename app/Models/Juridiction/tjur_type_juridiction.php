<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_type_juridiction extends Model
{
    protected $fillable=['id','nom_type_jur'];
    protected $table = 'tjur_type_juridiction';
}



