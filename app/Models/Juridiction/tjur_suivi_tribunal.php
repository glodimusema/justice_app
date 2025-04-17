<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_suivi_tribunal extends Model
{
    protected $fillable=['id','id_tribunal','date_liberte','date_prononce','author','refUser'];
    protected $table = 'tjur_suivi_tribunal'; 
}



