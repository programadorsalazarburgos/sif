<?php

namespace App\Modulos\FortalecimientoExterno;

use Illuminate\Database\Eloquent\Model;

class SesionFortalecimientoExterno extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_sesiones_fortalecimiento_externo';
    public $timestamps = false;

    protected $fillable = [
        'fk_dupla',
        'fk_grupo',
        'fecha_sesion',
        'fecha_registro',
        'quien_registro'
    ];

    /**
    * Accesores
    */
    public function getFechaSesionAttribute($value){
        return date("d/m/Y", strtotime($value));
    }
}
