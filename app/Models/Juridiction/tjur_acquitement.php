<?php

namespace App\Models\Juridiction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tjur_acquitement extends Model
{
    protected $fillable=['id','id_suivi_tribunal','date_acquitement','mondat_elargissement',
    'jour_liberation','author','refUser'];
    protected $table = 'tjur_acquitement'; 
}



