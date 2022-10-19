<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaPersona extends Model
{
    use HasFactory;
    protected $table = 'area_persona' ;
    protected $fillable = [
        'id_area',
        'id_persona',
        'estado',
        'fecha',
    ];
}
