<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocDetalle extends Model
{
    use HasFactory;
    protected $table = 'detalle_doc' ;
    protected $fillable = [
        'id_areapersona',
        'id_bien'
    ];
}
