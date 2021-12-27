<?php

namespace App\Modulos\FortalecimientoExterno;

use Illuminate\Database\Eloquent\Model;
use App\Models\nidos\territorial\Dupla;

class GrupoFortalecimientoExterno extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_grupos_fortalecimiento_externo';
    public $timestamps = false;

    /**
    * Relaciones
    */

    public function participantes(){
        return $this->belongsToMany(ParticipanteFortalecimientoExterno::class, ParticipanteGrupoFortalecimientoExterno::class, "fk_grupo", "fk_participante");
    }

    public function dupla(){
        return $this->hasOne(Dupla::class, "Pk_Id_Dupla", "fk_dupla");
    }
}
