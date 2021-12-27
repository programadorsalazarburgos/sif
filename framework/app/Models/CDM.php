<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CDM extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_centro_monitoreo';
    protected $primaryKey = 'PK_id_centro_monitoreo';

    public function getEstadisticas()
    {
        $cdm = cdm::all();
        return $cdm;
    }

    public function getSql($indicador)
    {
        $sql = cdm::select('TX_sql', 'VC_filtros')
            ->where('VC_numeral', '=', $indicador)
            ->get();
        return $sql;
    }

    public function executeSql($sql, $filtros)
    {
        //echo $sql.'-'.$filtros;
        /* SET de filtros a aplicar */
        if ($filtros != null) {
            $filtros = explode(",", $filtros);
            $sqlSET = "";
            for ($i = 0; $i < count($filtros); $i++) {
                if ($filtros[$i] != "") {
                    $valor = explode(":", $filtros[$i]);
                    // if($valor[0] == 'SL_LINEA_CREA' AND strlen($valor[1] > 1)){
                    // 	$valor[1] = '1,2,3';
                    // }
                    $sqlSET = "SET @" . $valor[0] . "=" . $valor[1] . ";";
                    cdm::raw($sqlSET);
                }
            }
        }
        $consultas = explode(";", $sql);
        $sentencia = null;
        for ($i = 0; $i < count($consultas); $i++) {
            if ($consultas[$i] != "") {
                $resultado = cdm::raw($consultas[$i]);
            }
        }
        return cdm::select('1');
    }

    public function getEstadisticasAnioAnterior($year)
    {
        $this->table = 'tb_estadistica_anio';
        $resultado = cdm::select('*')
            ->where('PK_Anio', '=', $year)
            ->get();
        return $resultado;
    }

    public function getListadoTipoIndicadores()
    {
        $resultado = cdm::select('tb_proyectos.nombre AS PROGRAMA', 'tb_parametro_detalle.VC_Descripcion AS TIPO_INDICADOR','tb_parametro_detalle.FK_Value AS ID_TIPO_INDICADOR', 'tb_centro_monitoreo.IN_seccion AS SECCION', 'tb_centro_monitoreo.IN_ordenacion')
        ->join('tb_proyectos','tb_centro_monitoreo.IN_seccion','=','tb_proyectos.id')
        ->join('tb_parametro_detalle', function($join){
            $join->on('tb_parametro_detalle.FK_Value','=','tb_centro_monitoreo.FK_tipo_indicador');
            $join->on('tb_parametro_detalle.FK_Id_Parametro','=',cdm::raw("'40'"));
        })->where('tb_centro_monitoreo.IN_Estado','=', '1')
        ->groupBy('tb_centro_monitoreo.IN_seccion','tb_centro_monitoreo.FK_tipo_indicador')
        ->orderBy('tb_centro_monitoreo.IN_seccion', 'asc')
        ->get();
        return $resultado;
    }

    public function getIndicadores($seccion, $id_tipo_indicador, $year)
    {
        $resultado = cdm::select('tb_centro_monitoreo.VC_numeral', 'tb_centro_monitoreo.VC_titulo', 'tb_centro_monitoreo.TX_descripcion', 'tb_centro_monitoreo.VC_tipo_grafico', 'tb_centro_monitoreo.TX_sql', 'tb_parametro_detalle.VC_Descripcion', 'tb_centro_monitoreo.VC_filtros', 'tb_centro_monitoreo.VC_descripcion_filtros', 'tb_centro_monitoreo.TX_Avance', 'tb_centro_monitoreo.IN_magnitud', 'tb_centro_monitoreo.VC_width', 'tb_centro_monitoreo.VC_Tipo_Avance')
            ->join("tb_parametro_detalle", function ($join) {
                $join->where("tb_parametro_detalle.FK_Id_Parametro", "=", '40')
                    ->on("tb_parametro_detalle.FK_Value", "=", "tb_centro_monitoreo.FK_tipo_indicador");
            })
            ->where([['IN_seccion', '=', $seccion], ['FK_tipo_indicador', '=', $id_tipo_indicador], ['tb_centro_monitoreo.IN_estado', '=', 1], ['tb_centro_monitoreo.VC_vigencia', 'LIKE', "%" . $year . "%"]])
            ->orderBy('tb_centro_monitoreo.IN_ordenacion', 'asc')
            ->get();
        return $resultado;
    }

    public function getFiltrosIndicadores($seccion, $id_tipo_indicador, $year)
    {
        $this->table = 'tb_centro_monitoreo';
        $resultado = cdm::selectRaw("GROUP_CONCAT(VC_filtros) AS filtros")
            ->where([['IN_seccion', '=', $seccion], ['FK_tipo_indicador', '=', $id_tipo_indicador], ['VC_vigencia', 'LIKE', "%" . $year . "%"], ['IN_estado', '=', "1"]])
            ->groupBy('IN_seccion')
            ->get();
        return $resultado;
    }

    public function getIndicadoresProyecto($seccion)
    {
        $resultado = cdm::select('tb_centro_monitoreo.PK_id_centro_monitoreo', 'tb_centro_monitoreo.VC_titulo', 'tb_centro_monitoreo.TX_descripcion', 'tb_centro_monitoreo.VC_tipo_grafico', 'tb_centro_monitoreo.IN_magnitud', 'tb_centro_monitoreo.FK_unidad', 'tb_centro_monitoreo.VC_Tipo_Avance', 'tb_parametro_detalle.VC_Descripcion as nombre_unidad', 'tb_proyectos.nombre AS nombre_proyecto')
            ->join("tb_parametro_detalle", "tb_parametro_detalle.FK_Value", "=", "tb_centro_monitoreo.FK_unidad")
            ->join("tb_proyectos", "tb_centro_monitoreo.IN_seccion", "=", "tb_proyectos.id")
            ->where([['IN_seccion', '=', $seccion], ['FK_tipo_indicador', '=', 8], ['tb_centro_monitoreo.IN_estado', '=', 1], ["tb_parametro_detalle.FK_Id_Parametro", "=", '54']])
            ->orderBy('tb_centro_monitoreo.IN_ordenacion', 'asc')
            ->get();
        return $resultado;
    }
}
