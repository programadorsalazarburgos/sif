<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;

class Territorio extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_persona_territorio';

	public function getTerritorioPersona($id_persona){
		$territorio = Territorio::select("Pk_Id_Territorio", "Vc_Nom_Territorio")
		->join('tb_nidos_territorios', 'Pk_Id_Territorio', '=', 'Fk_Id_Territorio')
		->where([
			['IN_Estado', '=', '1'],
			['Fk_Id_Persona', '=', $id_persona]
		])
		->get();
		
		return $territorio;
	}
}
