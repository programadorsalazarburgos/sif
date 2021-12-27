<?php

namespace App\Http\Controllers\crea\ArtistaFormador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InformeMensualGrupo;

class ReporteRevisionesController extends Controller
{
    public function getReporteInicial(Request $request) {
        $model = new InformeMensualGrupo;
        $filtro_estado = $request->has('estado') ? $request['estado'] : null;
        $filtro_linea = $request->has('linea_atencion') ? $request['linea_atencion'] : null;
        $result = $model->getReporteInicial(/*$request['id_usuario']*/384, date('Y-m', strtotime($request['anio_mes'])), $filtro_linea, $filtro_estado);
        return response()->json(json_decode($result), 200);
    }
    public function getReporteDetallado(Request $request) {
        $model = new InformeMensualGrupo;
        $filtro_estado = $request->has('estado') ? $request['estado'] : null;
        $filtro_linea = $request->has('linea_atencion') ? $request['linea_atencion'] : null;
        $result = $model->getReporteDetallado(/*$request['id_usuario']*/384, date('Y-m', strtotime($request['anio_mes'])), $filtro_linea, $filtro_estado);
        return response()->json(json_decode($result), 200);
    }   
}
