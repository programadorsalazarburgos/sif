<?php

namespace App\Models\nidos\fortalecimiento;

use Illuminate\Database\Eloquent\Model;

class ParticipanteGrupoFortalecimientoExterno extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_participantes_grupos_fortalecimiento_externo';
    public $timestamps = false;

    /**
    * Relaciones
    */
    public function participantes(){
        return $this->hasMany(ParticipanteFortalecimientoExterno::class, "id", "fk_participante");
    }
}
