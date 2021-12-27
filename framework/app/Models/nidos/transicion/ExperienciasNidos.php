<?php

namespace App\Models\nidos\transicion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExperienciasNidos extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_experiencia';
	public $timestamps = false;



public function getExperienciasRegistradasDupla($personaid, $mes){
    $sql = "SELECT EX.Pk_Id_Experiencia AS 'IdExperiencia', 
    LA.VC_Nombre_Lugar AS 'Lugar', 
    GT.nombre_grupo AS 'Grupo', 
    PD.VC_Descripcion AS 'Nivel', 
    EX.VC_Nombre_Experiencia AS 'Experiencia', 
    EX.DT_Fecha_Encuentro AS 'Fecha', 
    CONCAT(EX.HR_Hora_Inicio,' - ', EX.HR_Hora_Finalizacion) AS 'Horario',
    (SELECT COUNT(NA.Fk_Id_Beneficiario) FROM tb_nidos_asistencia AS NA 
    WHERE EX.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND NA.Vc_Asistencia = 1) AS 'Asistencia'
    FROM tb_nidos_experiencia AS EX
    JOIN tb_nidos_dupla_artista AS DA ON EX.Fk_Id_Dupla = DA.Fk_Id_Dupla
    JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
    JOIN tb_nidos_grupos_transicion AS GT ON EX.Fk_Id_Grupo = GT.id_grupo_transicion
    JOIN tb_parametro_detalle AS PD ON GT.fk_id_nivel_escolaridad = PD.FK_Value AND PD.FK_Id_Parametro = 58
    WHERE DA.Fk_Id_Persona = $personaid AND DA.IN_Estado = 1 
    AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') ORDER BY IdExperiencia";
    $grupos = DB::select($sql);
    return $grupos;
  }




}
