<?php

namespace App\Models\nidos\transicion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class AdministracionGrupos extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_grupos_transicion';
	public $timestamps = false;

	/*public function getGruposDuplaAsistencia($id_persona){
		$grupos = AdministracionGrupos::select("id_grupo_transicion as value", AdministracionGrupos::raw("CONCAT(LA.VC_Nombre_Lugar,' -> ',nombre_grupo) as text"))
		->join("tb_nidos_lugar_atencion as LA", "tb_nidos_grupos_transicion.fk_id_lugar_atencion", "=", "LA.Pk_Id_lugar_atencion")
		->join("tb_nidos_dupla_artista as DA", "tb_nidos_grupos_transicion.fk_id_dupla", "=", "DA.Fk_Id_Dupla")
		->where("LA.Pk_Id_lugar_atencion", "=", $id_persona)
		->get();
		return $grupos;
	} */

	public function getGruposDuplaAsistencia($personaid){
		$sql = "SELECT
		DISTINCT(GT.id_grupo_transicion) AS 'value',
		CONCAT(LA.VC_Nombre_Lugar,' -> ',GT.nombre_grupo) AS 'text'
		FROM tb_nidos_grupos_transicion AS GT
		JOIN tb_nidos_lugar_atencion AS LA ON GT.fk_id_lugar_atencion = LA.Pk_Id_lugar_atencion
		JOIN tb_nidos_dupla_artista AS DA ON GT.fk_id_dupla = DA.Fk_Id_Dupla
		WHERE DA.Fk_Id_Persona = $personaid AND DA.IN_Estado = 1";
		$grupos = DB::select($sql);
		return $grupos;
	  }

/*	public function getGruposDupla(){
		$grupos = AdministracionGrupos::select("id_grupo_transicion AS IdGrupo", "fk_id_lugar_atencion AS IdLugar", "LA.VC_Nombre_Lugar AS Lugar", "nombre_grupo AS Grupo", "fk_id_nivel_escolaridad AS IdNivelEscolaridad", "PD.VC_Descripcion AS Nivel", "tb_nidos_grupos_transicion.in_estado AS Estado")
		->join("tb_nidos_lugar_atencion AS LA", "fk_id_lugar_atencion", "=", "LA.Pk_Id_lugar_atencion")
		->leftjoin("tb_parametro_detalle AS PD", "fk_id_nivel_escolaridad", "=", "PD.FK_Value")
		->where([
			["PD.FK_Id_Parametro", "=", "58"]
		])
		->get();

		return $grupos;
	}  
	
	SELECT
DISTINCT(GT.id_grupo_transicion) AS IdGrupo,
CONCAT(LA.VC_Nombre_Lugar,' -> ',GT.nombre_grupo) AS Grupo
FROM tb_nidos_grupos_transicion AS GT
JOIN tb_nidos_lugar_atencion AS LA ON GT.fk_id_lugar_atencion = LA.Pk_Id_lugar_atencion
JOIN tb_nidos_dupla_artista AS DA ON GT.fk_id_dupla = DA.Fk_Id_Dupla
WHERE DA.Fk_Id_Persona = 1390 AND DA.IN_Estado = 1	*/

	public function getGruposDupla($personaid){
		$sql = "SELECT
		DISTINCT(GT.id_grupo_transicion) AS IdGrupo,
		LO.VC_Nom_Localidad AS Localidad,
		GT.fk_id_lugar_atencion AS IdLugar, 
		LA.VC_Nombre_Lugar AS Lugar,
		GT.nombre_grupo AS Grupo,
		GT.fk_id_nivel_escolaridad AS IdNivelEscolaridad,
		PD.VC_Descripcion AS Nivel,
		(SELECT COUNT(DISTINCT BT.Fk_Id_Beneficiario) 
		FROM tb_nidos_beneficiario_grupo_transicion AS BT
		WHERE BT.Fk_Id_Grupo = GT.id_grupo_transicion) AS Beneficiarios,
		GT.in_estado AS Estado,
		GT.fk_id_dupla,
		GT.responsable_grupo AS Responsable
		FROM tb_nidos_grupos_transicion AS GT
		JOIN tb_nidos_lugar_atencion AS LA ON GT.fk_id_lugar_atencion = LA.Pk_Id_lugar_atencion
		JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
		JOIN tb_nidos_dupla_artista AS DA ON GT.fk_id_dupla = DA.Fk_Id_Dupla
		LEFT JOIN tb_parametro_detalle AS PD ON GT.fk_id_nivel_escolaridad = PD.FK_Value AND PD.FK_Id_Parametro = 58
		WHERE DA.Fk_Id_Persona = $personaid AND DA.IN_Estado = 1";
		$grupos = DB::select($sql);
		return $grupos;
	  }

}
