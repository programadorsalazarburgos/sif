<?php

namespace App\Models\culturas\territorial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReporteMetasCuantitativas extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "tb_culturas_reporte_metas_cuantitativas";
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function getAllReportesMetasCuantitativas(){
        $resultado = ReporteMetasCuantitativas::select("id","tb_parametro_detalle.VC_Descripcion AS mes", ReporteMetasCuantitativas::raw("CONCAT(tb_persona_2017.VC_Primer_Nombre, ' ', tb_persona_2017.VC_Primer_Apellido) AS usuario"),"tx_nombre_actividad", "tx_descripcion_actividad", "da_fecha_inicio", "da_fecha_fin", "created_at", "url_anexos")
        ->join('tb_parametro_detalle', function ($join) {
            $join->on('tb_parametro_detalle.FK_Value', '=', 'in_mes');
            $join->on('tb_parametro_detalle.FK_Id_Parametro', '=', ReporteMetasCuantitativas::raw('8'));
        })->join('tb_persona_2017', function ($join) {
            $join->on('tb_persona_2017.PK_Id_Persona', '=', 'fk_usuario');
        })->get();
        return $resultado;
    }
    public function getAllReportesMetasCuantitativasByUser($id_usuario){
        $resultado = ReporteMetasCuantitativas::select("id","tb_parametro_detalle.VC_Descripcion AS mes", ReporteMetasCuantitativas::raw("JSON_UNQUOTE(JSON_EXTRACT(json_formulario, '$.SL_COMPONENTE_META.text')) AS componente_meta"), ReporteMetasCuantitativas::raw("CONCAT(tb_persona_2017.VC_Primer_Nombre, ' ', tb_persona_2017.VC_Primer_Apellido) AS usuario"),"tx_nombre_actividad", "tx_descripcion_actividad", "da_fecha_inicio", "da_fecha_fin", "created_at", "url_anexos", "tb_culturas_reporte_metas_cuantitativas.in_estado")
        ->join('tb_parametro_detalle', function ($join) {
            $join->on('tb_parametro_detalle.FK_Value', '=', 'in_mes');
            $join->on('tb_parametro_detalle.FK_Id_Parametro', '=', ReporteMetasCuantitativas::raw('8'));
        })->join('tb_persona_2017', function ($join) {
            $join->on('tb_persona_2017.PK_Id_Persona', '=', 'fk_usuario');
        })->where('fk_usuario', $id_usuario)->get();
        return $resultado;
    }
    public function getAutoIncrementId(){
        $statement = DB::select("SHOW TABLE STATUS LIKE 'tb_culturas_reporte_metas_cuantitativas'");
        $nextId = $statement[0]->Auto_increment;
        return $nextId;
    }
    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }
    public function getReporteMetasCuantitativas($id){
        $resultado = ReporteMetasCuantitativas::find($id);
        return $resultado;
    }

    public function getReportesMetasCuantitativasByFilters($componente_meta, $mes){
        $resultado = ReporteMetasCuantitativas::select("id","tb_parametro_detalle.VC_Descripcion AS mes", ReporteMetasCuantitativas::raw("JSON_UNQUOTE(JSON_EXTRACT(json_formulario, '$.SL_COMPONENTE_META.text')) AS componente_meta"), ReporteMetasCuantitativas::raw("CONCAT(tb_persona_2017.VC_Primer_Nombre, ' ', tb_persona_2017.VC_Primer_Apellido) AS usuario"),"tx_nombre_actividad", "tx_descripcion_actividad", "da_fecha_inicio", "da_fecha_fin", "created_at", "url_anexos", "tb_culturas_reporte_metas_cuantitativas.in_estado")
        ->join('tb_parametro_detalle', function ($join) {
            $join->on('tb_parametro_detalle.FK_Value', '=', 'in_mes');
            $join->on('tb_parametro_detalle.FK_Id_Parametro', '=', ReporteMetasCuantitativas::raw('8'));
        })->join('tb_persona_2017', function ($join) {
            $join->on('tb_persona_2017.PK_Id_Persona', '=', 'fk_usuario');
        })->where([['in_mes','=', $mes],[ReporteMetasCuantitativas::raw("JSON_UNQUOTE(JSON_EXTRACT(json_formulario, '$.SL_COMPONENTE_META.value'))"),'=', $componente_meta]])->get();
        return $resultado;
    }
}