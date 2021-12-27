<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Personas\Persona;
use App\Modulos\Grupos\PlaneacionGrupo;

class ValoracionGrupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tb_valoracion_grupo';
    protected $primaryKey= 'PK_Id_Valoracion';
    protected $fillable = [
        'FK_Grupo',
        'FK_Linea_Atencion',
        'FK_Periodo',
        'FK_Ciclo',
        'TX_Gesto_Cognitivo',
        'FK_Formador',
        'DA_Fecha',
        'VC_Nombre_Archivo',
        'VC_URL',
        'DA_Subida',
        'TX_Observacion',
        'IN_Estado',
        'FK_Id_AFA_Cambio',
        'DT_AFA_Cambio',
        'IN_Version',
        'JSON_formulario',
        'i_fk_id_planeacion',
        'in_finalizado',
        'i_fk_id_usuario_registro'
    ];
    public $timestamps = false;

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
        return $this->hasOne(Persona::class, "PK_Id_Persona", "i_fk_id_usuario_registro");
    }

    public function planeacion(){
        return $this->belongsTo(PlaneacionGrupo::class, "i_fk_id_planeacion", "PK_Id_Planeacion");
    }
}
