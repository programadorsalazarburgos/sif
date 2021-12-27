<?php

namespace App\Models\nidos\contenidos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeneficiarioContenido extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_beneficiario_contenido';
    public $timestamps = false;

    public function getInformeBeneficiariosConInfo($mes, $tipo_consulta){
    	$anio = date("Y");
    	$sql = "SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, LOCALIDAD, UPZ, BARRIO, LUGAR_ATENCION, CONTENIDO,
    	COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
    	COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
    	COALESCE(GESTANTES_R,0) AS GESTANTES_R,
    	COALESCE(AFRODESCENDIENTE_R,0) AS AFRODESCENDIENTE_R,
    	COALESCE(ROM_R,0) AS ROM_R,
    	COALESCE(INDIGENA_R,0) AS INDIGENA_R,
    	COALESCE(CONFLICTO_R,0) AS CONFLICTO_R,
    	COALESCE(DISCAPACIDAD_R,0) AS DISCAPACIDAD_R,
    	COALESCE(NINGUNO_R,0) AS NINGUNO_R,
    	COALESCE(PRIVADOS_R,0) AS PRIVADOS_R,
    	COALESCE(RAIZALES_R,0) AS RAIZALES_R,
    	COALESCE(CAMPESINA_R,0) AS CAMPESINA_R,
    	COALESCE(MUJERES_VICTIMAS_R,0) AS MUJERES_VICTIMAS_R,
    	COALESCE(TOTAL_R,0) AS TOTAL_R        
    	FROM (SELECT DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS LOCALIDAD, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
    	GROUP_CONCAT(DISTINCT(C.VC_Nombre_Contenido) SEPARATOR ', ') AS CONTENIDO
    	FROM tb_nidos_beneficiario_contenido AS BC
    	JOIN tb_nidos_contenido AS C ON C.PK_Id_Contenido=BC.Fk_Id_Contenido
    	JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=BC.Fk_Id_Lugar_atencion
    	JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
    	JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad ";

    	if($tipo_consulta == 1)
    		$sql .= "JOIN tb_nidos_persona_territorio AS PT ON PT.Fk_Id_Persona=BC.Fk_Id_Usuario_Registro ";

    	$sql .= "WHERE (BC.DT_Fecha_Entrega_Contenido BETWEEN '$anio-$mes-01' AND '$anio-$mes-31')
    	GROUP BY BC.Fk_Id_Lugar_atencion
    	ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
    	(SELECT
    	COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) <= 3 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
    	COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) <= 5 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
    	COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) >= 6 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS GESTANTES_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS AFRODESCENDIENTE_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS ROM_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS INDIGENA_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS CONFLICTO_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS DISCAPACIDAD_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS NINGUNO_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS PRIVADOS_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS RAIZALES_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= $anio-$mes-31 FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS CAMPESINA_R,
    	COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 17 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS MUJERES_VICTIMAS_R,
    	COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Entrega_Contenido) <= 99 AND
    	(SELECT BC.DT_Fecha_Entrega_Contenido >= '$anio-$mes-01' AND  BC.DT_Fecha_Entrega_Contenido <= '$anio-$mes-31' FROM tb_nidos_beneficiario_contenido AS BC
    	WHERE BC.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND YEAR(BC.DT_Fecha_Entrega_Contenido) = $anio ORDER BY BC.DT_Fecha_Entrega_Contenido ASC LIMIT 1) then 1 END) AS TOTAL_R,
    	DT.Fk_Id_lugar_atencion  
    	FROM
    	(SELECT B.DD_F_Nacimiento, B.IN_Grupo_Poblacional, BC.Fk_Id_Lugar_atencion, BC.DT_Fecha_Entrega_Contenido, BC.Fk_Id_Beneficiario
    	FROM tb_nidos_beneficiario_contenido AS BC
    	JOIN tb_nidos_beneficiarios AS B ON B.Pk_Id_Beneficiario=BC.Fk_Id_Beneficiario
    	WHERE (BC.DT_Fecha_Entrega_Contenido BETWEEN '$anio-$mes-01' AND '$anio-$mes-31')
    	GROUP BY BC.Fk_Id_Beneficiario) DT GROUP BY DT.Fk_Id_Lugar_atencion) AS SEGUNDA
    	ON PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion GROUP BY Pk_Id_lugar_atencion HAVING TOTAL_R > 0 ORDER BY IDLocalidad";

    	$informacion = DB::select($sql);
    	return $informacion;
    }
}
