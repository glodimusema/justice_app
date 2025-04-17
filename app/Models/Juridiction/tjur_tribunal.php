<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_tribunal extends Model
{
    protected $fillable=['id','id_president','id_arrestation','accompagne1','fonction1',
    'accompagne2','fonction2','author','refUser'];
    protected $table = 'tjur_tribunal'; 
}



