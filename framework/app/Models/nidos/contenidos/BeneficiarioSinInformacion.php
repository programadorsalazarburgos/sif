<?php

namespace App\Models\nidos\contenidos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeneficiarioSinInformacion extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_beneficiario_sin_informacion';
    // protected $primaryKey = 'PK_Id_Categoria';
    public $timestamps = false;

    public function getInformeBeneficiariosSinInfo($id_mes, $tipo_consulta){
    	$informacion = BeneficiarioSinInformacion::select(BeneficiarioSinInformacion::raw("GROUP_CONCAT(co.VC_Nombre_Contenido ORDER BY co.VC_Nombre_Contenido DESC SEPARATOR ', ') AS VC_Contenido,
    		DATE_FORMAT(DT_Fecha_Entrega, '%d/%m/%Y') AS DT_Fecha_Entrega,
    		l.VC_Nom_Localidad,
    		CONCAT(u.IN_Codigo_Upz, '. ', u.VC_Nombre_Upz) AS VC_Nombre_Upz,
    		la.VC_Nombre_Lugar,
    		e.Vc_Abreviatura,
    		la.VC_Barrio,
    		g.VC_Nombre_Grupo,
    		IN_Total_Beneficiarios,
    		IN_Total_Ninos,
    		IN_Total_Ninas,
    		IN_Total_Ninos_0_3,
    		IN_Total_Ninos_3_6,
    		IN_Total_Ninas_0_3,
    		IN_Total_Ninas_3_6,
    		IN_Mujeres_Gestantes,
    		IN_Afrodescendiente,
    		IN_Campesina,
    		IN_Discapacidad,
    		IN_Conflicto,
    		IN_Indigena,
    		IN_Privados,
    		IN_Victimas,
    		IN_Raizal,
    		IN_Rom,
    		VC_Documento_Soporte"))
    	->join("tb_nidos_lugar_atencion as la", "la.Pk_Id_lugar_atencion", "=", "Fk_Id_Lugar_Atencion")
    	->join("tb_nidos_grupos as g", "g.Pk_Id_Grupo", "=", "Fk_Id_Grupo")
    	->join("tb_localidades as l", "l.Pk_Id_Localidad", "=", "la.Fk_Id_Localidad")
    	->join("tb_upz as u", "u.Pk_Id_Upz", "=", "la.Fk_Id_Upz")
    	->join("tb_nidos_entidades as e", "e.Pk_Id_Entidad", "=", "la.Fk_Id_Entidad")
    	->join("tb_nidos_contenido as co", function($join){
    		$join->on(DB::Raw("FIND_IN_SET(co.PK_Id_Contenido, VC_Contenido)"), ">", \DB::raw("'0'"));
    	});

        if($tipo_consulta == 1)
            $informacion = $informacion->join("tb_nidos_persona_territorio as pt", "pt.Fk_Id_Persona", "=", "Fk_Id_Usuario_Registro");

        $informacion = $informacion->whereMonth("DT_Fecha_Entrega", "=", $id_mes)
        ->whereYear("DT_Fecha_Entrega", "=", date("Y"))
        ->groupBy("Pk_Id_Registro")
        ->get();

        return $informacion;
    }
}
