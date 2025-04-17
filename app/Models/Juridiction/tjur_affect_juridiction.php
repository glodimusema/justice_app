<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_affect_juridiction extends Model
{
    protected $fillable=['id','id_user','id_juridiction','id_ville','author','refUser'];
    protected $table = 'tjur_affect_juridiction'; 
}



