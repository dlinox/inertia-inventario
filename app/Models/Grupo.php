<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $table = 'grupo' ;
    protected $fillable = [
        'id_area',
        'id_usuario',
        'id_oficina',
    ];
}
