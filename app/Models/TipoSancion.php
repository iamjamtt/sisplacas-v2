<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSancion extends Model
{
    protected $table = 'tipes_sanctions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nombre',
    ];
}
