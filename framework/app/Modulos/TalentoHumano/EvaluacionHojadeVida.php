<?php

namespace App\Modulos\TalentoHumano;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Personas\Persona;

class EvaluacionHojadeVida extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_evaluacion_hoja_vida';
    public $timestamps = false;

    protected $fillable = [
        'id_hoja_vida',
        'id_parametro',
        'id_usuario',
        'valor'
    ];
    
    public function usuario(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "id_usuario");
    }
}