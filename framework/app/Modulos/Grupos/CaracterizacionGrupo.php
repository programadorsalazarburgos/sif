<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Personas\Persona;

class CaracterizacionGrupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tb_caracterizacion_grupo';
    protected $primaryKey= 'PK_Id_Caracterizacion';
    protected $fillable = [
        'FK_Grupo',
        'FK_Id_Linea_Atencion',
        'FK_Ciclo',
        'TX_Descripcion_Grupo',
        'IN_Escala_Convivencia',
        'TX_Convivencia',
        'TX_Array_Intereses',
        'TX_Descripcion_Intereses',
        'IN_Escala_Actitudinal',
        'TX_Actitudinal',
        'IN_Escala_Cognitiva',
        'TX_Cognitiva',
        'IN_Escala_Procedimental',
        'TX_Procedimental',
        'VC_Necesidades',
        'VC_Etnias',
        'TX_Particularidades',
        'TX_Descripcion_Espacio',
        'TX_Observaciones',
        'FK_Id_Usuario_Registro',
        'TX_Observacion',
        'IN_Estado',
        'FK_Id_AFA_Cambio',
        'DT_AFA_Cambio',
        'DA_Fecha_Registro',
        'IN_Version',
        'VC_Tipo',
        'IN_Finalizado',
        'JSON_formulario',
        'i_flag'
    ];
    public $timestamps = false;

    public function nuevoRegistro($info) {
        return CaracterizacionGrupo::create($info);
    }

    public function grupoArte(){
    	return $this->hasOne(GrupoArteEscuela::class, "PK_Grupo", "FK_Grupo");
    }

    public function grupoImpulso(){
    	return $this->hasOne(GrupoEmprendeClan::class, "PK_Grupo", "FK_Grupo");
    }

    public function grupoConverge(){
    	return $this->hasOne(GrupoLaboratorioClan::class, "PK_Grupo", "FK_Grupo");
    }

    public function user(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_Id_Usuario_Registro");
    }

    public function planeacion(){
        return $this->hasOne(PlaneacionGrupo::class, "i_fk_id_caracterizado", "PK_Id_Caracterizacion");
    }

}
