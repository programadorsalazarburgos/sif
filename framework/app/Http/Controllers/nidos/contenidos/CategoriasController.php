<?php

namespace App\Http\Controllers\nidos\contenidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\contenidos\Categoria;

class CategoriasController extends Controller
{
	public function getCategorias(Request $request){
		$categoria = new Categoria;
		$resultado = $categoria->getCategorias($request["tipo_consulta"]);
		return response()->json(json_decode($resultado), 200);
	}

	public function guardarNuevaCategoria(Request $request){
		$categoria = new Categoria;
		$categoria->VC_Nombre_Categoria = $request->nombre_nueva_categoria;
		$categoria->IN_Estado = $request->estado_categoria;
		$categoria->save();
	}

	public function modificarCategoria(Request $request){
		$categoria = new Categoria;	
		$categoria->where('PK_Id_Categoria', $request->id_categoria)->update(array('VC_Nombre_Categoria' => $request->nombre_categoria, 'IN_Estado' => $request->estado_categoria));
	}
}
