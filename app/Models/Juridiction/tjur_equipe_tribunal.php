<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_equipe_tribunal extends Model
{
    protected $fillable=['id','id_membre','id_tribunal','fonction_tribunal','author','refUser'];
    protected $table = 'tjur_equipe_tribunal'; 
}



