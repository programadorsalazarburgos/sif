<?php

namespace App\Modulos\TalentoHumano;

use Illuminate\Database\Eloquent\Model;

class ParametrosEvaluacionHojadeVida extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_parametros_evaluacion_hoja_vida';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'rol'
    ];
}