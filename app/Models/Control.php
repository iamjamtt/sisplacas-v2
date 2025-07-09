<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'controls';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_vehicle',
        'ingreso',
        'foto_ingreso',
        'foto_ingreso_2',
        'salida',
        'foto_salida',
        'foto_salida_2',
        'fecha',
    ];

    protected $casts = [
        'ingreso' => 'datetime',
        'salida' => 'datetime',
        'fecha' => 'date',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehicle', 'id');
    }
}
