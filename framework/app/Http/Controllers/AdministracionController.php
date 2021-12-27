<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\tb_estadistica_anio;
use App\Models\Options;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class AdministracionController extends Controller
{
    public function view_AdministrarMetasEstadisticas(){
        return view('administracion.administracion_metas_estadisticas');
    }

    public function saveMetasEstadisticas(Request $request){
        $model = new tb_estadistica_anio;
        $areas_artisticas = $request->JSON_AREAS;
        $metas_convenios = $request->METAS_CONVENIOS;
        //print_r($areas_artisticas);
        $array_formadores_area = [];
        $array_metas = ["ae"=>$request->TX_META_COBERTURA_AE, "ic"=>$request->TX_META_COBERTURA_IC, "cv"=>$request->TX_META_COBERTURA_CV];
        $array_grupos = [];
        $array_grupos_linea = [];

        for($i=0; $i < count($areas_artisticas);$i++){
            foreach ($areas_artisticas[$i] as $clave => $valor) {
                if(strpos($clave, "grupos") !== false){
                    $array_grupos_linea[str_replace("grupos_","",$clave)][$areas_artisticas[$i]['value']] = $areas_artisticas[$i][$clave];
                }
            }
            $array_formadores_area[$areas_artisticas[$i]['value']] = $areas_artisticas[$i]['formadores'];
        }
        
        $json_meta_anual = $model->select('TX_Meta_Cobertura_Anual_CREA')->where('PK_Anio', $request->SL_ANIO)->get();
        $cobertura_anual = json_decode($json_meta_anual[0]['TX_Meta_Cobertura_Anual_CREA'], true)['X'];
        $array_meta_anual = ["X" => $cobertura_anual, "Y" => $request->TX_META_COBERTURA];

        $result = $model->where('PK_Anio', $request->SL_ANIO)
          ->update(['TX_Formadores_Area' => json_encode($array_formadores_area), 'TX_Grupos_Area' => json_encode($array_grupos_linea), 'TX_Meta_Cobertura_Anual_Linea' => json_encode($array_metas), 'TX_Meta_Cobertura_Anual_CREA' => json_encode($array_meta_anual), 'TX_Meta_Cobertura_Anual_Convenios' => json_encode($metas_convenios)]);
        return $result;
    }

    public function getMetasEstadisticas(Request $request){
        $model = new tb_estadistica_anio;
        $year = $request->SL_ANIO;
        $result = $model->find($year);
        return json_encode($result);
    }

    public function getConveniosById(Request $request){
        $options = new Options;
        $resultado = $options->getConveniosById($request->id_convenios);
        return response()->json(json_decode($resultado), 200);
    }
}
