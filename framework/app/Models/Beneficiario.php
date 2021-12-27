<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Beneficiario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_estudiante';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getBeneficiariosCirterio($parametro, $opcBusqueda)
    {
        $nombre = "IF(".$this->table.".VC_Segundo_nombre IS NULL OR ".$this->table.".VC_Segundo_nombre = '', CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido), ' ', TRIM(".$this->table.".VC_Segundo_Apellido)), CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido), ' ', TRIM(".$this->table.".VC_Segundo_Apellido)))";
        $resultado = Beneficiario::select($this->table.'.id', $this->table.'.IN_Identificacion as identificacion', DB::raw($nombre.' as nombre'), 'tb_colegios.VC_Nom_Colegio as colegio', 'tb_grado.VC_Descripcion_Grado as grado')
        ->leftJoin('tb_estudiante_detalle_anio', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_estudiante','=',$this->table.'.id');
            $join->on('tb_estudiante_detalle_anio.anio','=',DB::raw('YEAR(NOW())'));
        })
        ->leftJoin('tb_colegios','tb_estudiante_detalle_anio.FK_colegio','=','tb_colegios.PK_Id_Colegio')
        ->leftJoin('tb_grado','tb_estudiante_detalle_anio.FK_grado','=','tb_grado.PK_Id_Grado');
        if($opcBusqueda == 'nombres') {
            $resultado->where(DB::raw($nombre),'LIKE', '%'.$parametro.'%')
            // Nombre 1, Nombre 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Segundo_nombre))"),'LIKE','%'.$parametro.'%')
            // Apellido 1, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Apellido), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 1, Apellido 1
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 1, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 2, Apellido 1
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 2, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 1, Nombre 2, Apellido 1
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 1, Nombre 2, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 1, Apellido 1, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Primer_Nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%')
            // Nombre 2, Apellido 1, Apellido 2
            ->orWhere(DB::raw("CONCAT(TRIM(".$this->table.".VC_Segundo_nombre), ' ', TRIM(".$this->table.".VC_Primer_Apellido), ' ', TRIM(".$this->table.".VC_Segundo_Apellido))"),'LIKE','%'.$parametro.'%');
            
        }
        if($opcBusqueda == 'documento') {
            $resultado->where($this->table.'.IN_Identificacion','=',$parametro);
        }
        
        $resultado->orderBy('nombre', 'asc');
        return $resultado->get();
    }
    
    public function getBeneficiario($id) {
        return Beneficiario::find($id);
    }

    public function actualizarBeneficiario($id, $cambios, $usuario = null) {
        DB::statement('SET @user_id = '.$usuario);
        return Beneficiario::where('id', $id)
        ->update($cambios);
    }

    public function ValidaDocumentoBeneficiario($numero_documento) {
        return Beneficiario::where('IN_Identificacion', "=", $numero_documento)->exists();
    }
}
