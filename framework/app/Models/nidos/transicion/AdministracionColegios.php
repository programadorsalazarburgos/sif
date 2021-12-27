<?php

namespace App\Models\nidos\transicion;

use Illuminate\Database\Eloquent\Model;

class AdministracionColegios extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_lugar_atencion';
	public $timestamps = false;

    

	public function getColegiosConvenioSED(){
		$lugares = AdministracionColegios::select("Pk_Id_lugar_atencion AS IdLugar", "tb_nidos_lugar_atencion.Fk_Id_Localidad AS IdLocalidad", "L.VC_Nom_Localidad AS Localidad", "Fk_Id_Upz AS IdUpz", "U.VC_Nombre_Upz AS Upz", "VC_Barrio AS Barrio", "VC_Direccion AS Direccion",	"VC_Nombre_Lugar AS Lugar", "VC_Dane12 AS Dane",	"IN_Componente AS Componente", "IN_Estado AS EstadoLugar")
		->join("tb_localidades AS L", "tb_nidos_lugar_atencion.Fk_Id_Localidad", "=", "L.Pk_Id_Localidad")
		->leftjoin("tb_upz AS U", "Fk_Id_Upz", "=", "U.Pk_Id_Upz")
		->where([
			["Fk_Id_Entidad", "=", "3"],
			["IN_Componente", "=", "3"]
		])
		->get();

		return $lugares;
	}

	public function getLugaresAtenciontransicion($id_localidad){
        $resultado = AdministracionColegios::select("Pk_Id_lugar_atencion as value", "VC_Nombre_Lugar as text")
        ->join("tb_localidades AS LO", "tb_nidos_lugar_atencion.Fk_Id_Localidad", "=", "LO.Pk_Id_Localidad")
		->where([
			["Fk_Id_Localidad", "=", $id_localidad],
			["IN_Estado", "=", 1],
            ["IN_Componente", "=", 3]
        ])
        ->orderBy("VC_Nombre_Lugar")
        ->get();
        return $resultado;
    }

}
