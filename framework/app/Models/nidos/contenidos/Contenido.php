<?php

namespace App\Models\nidos\contenidos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contenido extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_contenido';
    // protected $primaryKey = 'PK_Id_Categoria';
	public $timestamps = false;

	public function getContenidosPorCategoria($id_categoria){
		$contenidos = Contenido::select("*")
		->where('FK_Id_Categoria', $id_categoria)
		->get();
		return $contenidos;
	}

	public function getContenidos(){
		$sql = "SELECT
		CONCAT('[',GROUP_CONCAT(subquery.json),']') as 'json' FROM (
		SELECT
		CONCAT(
		'{\"categoria\":\"', cc.VC_Nombre_Categoria,
		'\",\"cont\":[',(SELECT GROUP_CONCAT(JSON_OBJECT('value',c.PK_Id_Contenido, 'name', c.VC_Nombre_Contenido))),']}') AS 'json'
		FROM tb_nidos_contenido as c
		JOIN tb_nidos_categoria as cc ON cc.PK_Id_Categoria=c.FK_Id_Categoria
		WHERE c.IN_Estado=1 AND cc.IN_Estado=1
		GROUP BY c.FK_Id_Categoria) AS subquery";
		$contenidos = DB::select($sql);
		return $contenidos;
	}
}
