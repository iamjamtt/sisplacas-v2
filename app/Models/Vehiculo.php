<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_tipes_sanctions',
        'placa',
        'apellido',
        'nombre',
        'nombre_completo',
        'conductor',
        'marca',
        'modelo',
        'estado',
        'tieneSancion',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'tieneSancion' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function sancion()
    {
        return $this->belongsTo(TipoSancion::class, 'id_tipes_sanctions', 'id');
    }

    public function controles()
    {
        return $this->hasMany(Control::class, 'id_vehicle', 'id');
    }
}
