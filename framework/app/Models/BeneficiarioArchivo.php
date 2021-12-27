<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeneficiarioArchivo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_estudiante_archivo';
    protected $primaryKey = 'PK_estudiante_archivo';
    public $timestamps = false;
    protected $fillable = ['PK_estudiante_archivo', 'FK_Id_Estudiante', 'VC_Nombre_Archivo', 'VC_Url', 'DA_Fecha_Subida', 'FK_Usuario_Creacion', 'Anio', 'TX_Observacion'];


    public function getAniosDocumentos($id) {
        return BeneficiarioArchivo::select(DB::raw('DISTINCT(anio) AS anio'))
        ->where('FK_Id_estudiante', $id)
        ->orderBy('anio', 'asc')
        ->get();
    }

    public function getDocumentosBeneficiario($id_estudiante, $anio) {
        return BeneficiarioArchivo::where([
            ['FK_Id_Estudiante', '=', $id_estudiante],
            ['Anio', '=', $anio]
        ])->get();
    }

    public function deleteDocumentoxAnio($id_estudiante, $anio, $nombre_archivo) {
        return BeneficiarioArchivo::where([
            ['FK_Id_Estudiante', '=', $id_estudiante],
            ['Anio', '=', $anio],
            ['VC_Nombre_Archivo','LIKE', $nombre_archivo.'%']
        ])->delete(); 
    }

    public function saveDocumentoxAnio($info) {
        return BeneficiarioArchivo::create($info);
    }

}
