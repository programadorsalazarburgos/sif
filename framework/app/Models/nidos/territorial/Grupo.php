<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_grupos';

    public function getGruposLugar($id_lugar){
    	$grupos = Grupo::select("Pk_Id_Grupo AS value", "VC_Nombre_Grupo AS text")
    	->where([
    		["IN_Estado", "=", "1"],
    		["Fk_Id_Lugar_Atencion", "=", $id_lugar]
    	])
    	->get();

    	return $grupos;
    }
}
