<?php 

namespace App\Modulos\CrudInterface\Repository;

interface CRUDInterface 
{
	public function crear($data);
	public function actualizar($data, $id);
	public function obtener($id, $relaciones = []);
	public function eliminar($id);
	public function obtenerTodo($relaciones = []);
	public function dataTable($relaciones = []);
}