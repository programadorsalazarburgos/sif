<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Personas\Persona;

class PlaneacionGrupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tb_planeacion_grupo';
    protected $primaryKey= 'PK_Id_Planeacion';
    protected $fillable = [
        'FK_grupo',
        'FK_Id_Linea_atencion',
        'FK_Ciclo',
        'VC_Objetivo',
        'VC_Pregunta',
        'VC_Descripcion',
        'VC_Metodologia',
        'VC_Temas',
        'VC_Recursos',
        'VC_Referentes',
        'VC_Propuesta_Circulacion',
        'VC_Acciones',
        'FK_Id_Usuario_Registro',
        'DA_Fecha_Registro',
        'VC_Observacion',
        'VC_Resultados',
        'VC_Articulacion',
        'VC_Ciclo',
        'IN_Estado',
        'FK_Id_AFA_Cambio',
        'DT_AFA_Cambio',
        'IN_Version',
        'IN_Finalizado',
        'JSON_formulario',
        'json_semanas',
        'i_fk_id_caracterizado'
    ];
    public $timestamps = false;

    public function grupoArte(){
    	return $this->hasOne(GrupoArteEscuela::class, "PK_Grupo", "FK_grupo");
    }

    public function grupoImpulso(){
    	return $this->hasOne(GrupoEmprendeClan::class, "PK_Grupo", "FK_grupo");
    }

    public function grupoConverge(){
    	return $this->hasOne(GrupoLaboratorioClan::class, "PK_Grupo", "FK_grupo");
    }

    public function user(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_Id_Usuario_Registro");
    }

    public function caracterizacion(){
        return $this->belongsTo(CaracterizacionGrupo::class, "i_fk_id_caracterizado", "PK_Id_Caracterizacion");
    }

}
