<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_lugar_atencion as la';

	public function getLugaresTerritorio($id_territorio){
		$lugares = Lugar::select("la.Pk_Id_lugar_atencion AS value", "la.VC_Nombre_Lugar AS text")
		->join("tb_nidos_terri_locali as tl", "la.Fk_Id_Localidad", "=", "tl.Fk_Id_Localidad")
		->where([
			["la.IN_Estado", "=", "1"],
			["tl.Fk_Id_Territorio", "=", $id_territorio]
		])
		->get();

		return $lugares;
	}

	public function getInfoLugar($id_lugar){
		$info_lugar = Lugar::select("l.VC_Nom_Localidad as localidad", Lugar::raw("CONCAT(u.IN_Codigo_Upz, '. ', u.VC_Nombre_Upz) as upz"), "e.Vc_Nom_Entidad as entidad", "la.VC_Barrio as barrio")
		->join("tb_nidos_entidades as e", "e.Pk_Id_Entidad", "=", "la.Fk_Id_Entidad")
		->join("tb_localidades as l", "l.Pk_Id_Localidad", "=", "la.Fk_Id_Localidad")
		->join("tb_upz as u", "u.Pk_Id_Upz", "=", "la.Fk_Id_Upz")
		->where("la.Pk_Id_lugar_atencion", "=", $id_lugar)
		->get();

		return $info_lugar;
	}
}
