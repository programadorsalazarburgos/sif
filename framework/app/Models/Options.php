<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\crea\territorial\Crea;
use App\Models\crea\territorial\Emprende;

class Options extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_parametro_detalle';

    public function gruposOfertaDisponible(){
        return $this->hasManyThrough(
            Emprende::class,
            Crea::class,
            'FK_Id_Localidad',
            'FK_clan',
            'FK_Value',
            'PK_Id_Clan');
    }

    public function getParametroDetalle($FK_Id_Parametro, $programa)
    {
        $this->table = 'tb_parametro_detalle';
        $resultado = options::select("VC_Descripcion as text", "FK_Value as value");

        if($programa == "crea")
            $resultado = $resultado->where([['FK_Id_Parametro', '=', $FK_Id_Parametro], ['IN_Estado', '=', 1]]);
        if($programa == "nidos")
            $resultado = $resultado->where([['FK_Id_Parametro', '=', $FK_Id_Parametro], ['IN_Estado_Nidos', '=', 1]]);
        if($programa == "culturas")
            $resultado = $resultado->where([['FK_Id_Parametro', '=', $FK_Id_Parametro], ['IN_Estado_Culturas', '=', 1]]);

        $resultado = $resultado->get();
        return $resultado;
    }

    public function getCentrosCrea()
    {
        $this->table = 'tb_clan';
        $resultado = options::select("VC_Nom_Clan as text", "PK_Id_Clan as value")
        ->where('IN_Estado', '=', 1)
        ->get();
        return $resultado;
    }

    public function getColegios($year)
    {
        $this->table = 'tb_terr_grupo_arte_escuela_sesion_clase';
        $resultado = options::select("tb_colegios.VC_Nom_Colegio AS text", "tb_colegios.PK_Id_Colegio AS value")
        ->join("tb_colegios", 'tb_colegios.PK_Id_Colegio', '=', "tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio")
        ->whereYear("tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase", "=", $year)
        ->groupBy("tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio")
        ->get();
        return $resultado;
    }

    public function getLineasNidos()
    {
        $this->table = 'tb_nidos_tipo_lugar';
        $resultado = options::select("Vc_Descripcion AS text", "Pk_Id_Lugar AS value")
        ->get();
        return $resultado;
    }

    public function getGruposAtendidosLineaAnio($id_linea_atencion,$year)
    {
        if($id_linea_atencion == 1) $this->table = 'tb_terr_grupo_arte_escuela_sesion_clase';
        if($id_linea_atencion == 2) $this->table = 'tb_terr_grupo_emprende_clan_sesion_clase';
        if($id_linea_atencion == 3) $this->table = 'tb_terr_grupo_laboratorio_clan_sesion_clase';
        $resultado = options::select("FK_grupo AS value", "FK_grupo AS text")
        ->whereYear('DA_fecha_clase', '=', $year)
        ->groupBy("FK_grupo")
        ->get();
        return $resultado;
    }

    public function getYearsEstadisticasAnio()
    {
        $this->table = 'tb_estadistica_anio';
        $resultado = options::select("PK_Anio AS text", "PK_Anio AS value")
        ->get();
        return $resultado;
    }

    public function getTipoDocumento(){
        $resultado = options::select("FK_Value as value", "VC_Descripcion as text")
        ->where([
            ["FK_Id_Parametro", "=", 5],
            ["IN_Estado_Nidos", "=", 1]
        ])
        ->orderBy("VC_Descripcion")
        ->get();
        return $resultado;
    }

    public function getGenero(){
        $resultado = options::select("FK_Value as value", "VC_Descripcion as text")
        ->where([
            ["FK_Id_Parametro", "=", 17],
            ["IN_Estado_Nidos", "=", 1]
        ])
        ->get();
        return $resultado;
    }

    public function getEnfoque(){
        $resultado = options::select("FK_Value as value", "VC_Descripcion as text")
        ->where([
            ["FK_Id_Parametro", "=", 14],
            ["IN_Estado_Nidos", "=", 1]
        ])
        ->orderBy("VC_Descripcion")
        ->get();
        return $resultado;
    }

    public function getEstrato(){
        $resultado = options::select("FK_Value as value", "VC_Descripcion as text")
        ->where([
            ["FK_Id_Parametro", "=", 53],
            ["IN_Estado_Nidos", "=", 1]
        ])
        ->orderBy("VC_Descripcion")
        ->get();
        return $resultado;
    }

    public function getMes(){
        $resultado = options::select("FK_Value as value", "VC_Descripcion as text")
        ->where([
            ["FK_Id_Parametro", "=", 8],
            ["IN_Estado_Nidos", "=", 1]
        ])
        ->orderBy("FK_Value")
        ->get();
        return $resultado;
    }

    public function getConveniosActivosCREA(){
        $resultado = options::select("FK_Id_Parametro AS parametro", "FK_Value AS valor", "VC_Descripcion AS nombre_convenio", options::raw("'0' AS contador_grupos"))
        ->where([
            ["IN_Estado", "=", 1],
            ["FK_Value", "!=", 0]
        ])
        ->whereIn("FK_Id_Parametro", array(68))
        ->orderBy("FK_Value")
        ->get();
        return $resultado;
    }

    public function getConveniosById($id_convenios){
        $resultado = options::select("IN_Estado AS estado","FK_Id_Parametro AS parametro", "FK_Value AS valor", "VC_Descripcion AS nombre_convenio", options::raw("'0' AS contador_grupos"))
        ->where([
            ["FK_Value", "!=", 0],
            ["FK_Id_Parametro", "=", 68]
        ])
        ->whereIn("FK_Value", $id_convenios)->orderBy("FK_Value")
        ->get();
        return $resultado;
    }

    public function getBarrios($localidad)
    {
        $this->table = 'tb_barrios';
        $resultado = options::select("VC_Barrio AS text", "PK_Id_Tabla AS value")
        //->join("tb_parametro_detalle", 'tb_parametro_detalle.FK_Value', '=', "tb_barrios.FK_Id_Localidad")
        ->where("FK_Id_Localidad", "=", $localidad)
        ->get();
        return $resultado;
    }

    public function getGruposPoblacionalesCulturas($FK_Id_Parametro)
    {
        $this->table = 'tb_parametro_detalle';
        $resultado = options::select("VC_Descripcion as text", "FK_Value as value", options::raw("0 as cantidad"));
        $resultado = $resultado->where([['FK_Id_Parametro', '=', $FK_Id_Parametro], ['IN_Estado_Culturas', '=', 1]]);

        $resultado = $resultado->get();
        return $resultado;
    }
}