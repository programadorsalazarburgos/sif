<?php

namespace App\Modulos\Crea\Repository;

use App\Modulos\Crea\Interfaces\FichaCreaInterface;
use App\Modulos\Crea\Crea;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Modulos\Parametros\ParametroDetalles;

class FichaCreaRepository implements FichaCreaInterface
{

	public function __construct(){}

	public function crear($data){}

	public function dataTable($relaciones=[]){}
	public function show($relaciones=[]){}

	public function actualizar($request, $id){}

	public function obtener($id, $relaciones = []){}
	public function eliminar($id){}
	public function obtenerTodo( $relaciones = []){}

	public function procesar($informeGestion, $convenio, $data){}

	public function obtenerTabla($request){}

}
