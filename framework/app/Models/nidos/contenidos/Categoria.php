<?php

namespace App\Models\nidos\contenidos;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'tb_nidos_categoria';
     // protected $primaryKey = 'PK_Id_Categoria';
     public $timestamps = false;

     public function getCategorias($tipo_consulta){
     	if($tipo_consulta == 1){
     		$categorias = Categoria::all();
     	}else{
     		$categorias = Categoria::select("PK_Id_Categoria AS value", "VC_Nombre_Categoria AS text")
     		->get();
     	}
     	return $categorias;
     }
 }
